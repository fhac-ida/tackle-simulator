<?php

namespace App\Http\Controllers;

use App;
use App\Models\Preview\Phase;
use App\Models\Preview\Scenario;
use App\Services\ScenarioService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Storage;

class HackerattackController extends Controller
{
    protected $scenarioService;

    protected $mitreData;

    /**
     * Constructor method for initializing the controller
     *
     * @param ScenarioService $scenarioService
     */
    public function __construct(ScenarioService $scenarioService)
    {
        $this->scenarioService = $scenarioService;

        $this->fetchMitreData();

        if (App::currentLocale() == null) { // If we want to add translations -> Ensure default value exists
            App::setLocale('en');
        }
    }

    /**
     * Execute the attack simulation based on the selected scenario and provided hardware nodes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function run_attack(Request $request)
    {
        // Setup the simulation. Take the selected scenario id, company profile baseline and map id from the end of the incoming json. The remaining data are the hardware nodes.
        $allReachedMapObjects = $request->json()->all();
        $scenarioId = array_pop($allReachedMapObjects)['scenario_id'];
        $scenario = Scenario::find($scenarioId);
        $allPossibleKillchains = $this->scenarioService->getAllPaths($scenario);
        $endPhase = Phase::where('is_end_phase', true)->first(); // As opposed to killchain hackersteps, these phases are not scenario specific. Therefore end-phase is always "Credential Access".

        $profileBaseline = array_pop($allReachedMapObjects)['profile_baseline'];
        if ($profileBaseline) { // Get an array of the maximum baseline value per domain from a string of domains of controls (i.E. "[[3,2,3,2,2],[2,1,2,0,2,1],...]" -> [3,2,...])
            $profileBaseline = array_map(function($domainVector) {
                return intval(max(explode(",", $domainVector)));
            }, explode("],[", substr($profileBaseline, 2, -2)));
        }
        else {
            $profileBaseline = [3,3,3,3,3]; // Not enough profile questions answered -> Max level everywhere
        }

        $mapId = array_pop($allReachedMapObjects)['map_id'];

        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'report_'.$timestamp.'.json';
        $filePath = storage_path('app/reports/'.$mapId.'/'.$filename); // Each map has its own report subdirectory named after its id. All hackerattack reports resulting from simulations on that map are saved there.
        $finalReport = [];

        $reachableMapObjects = [$allReachedMapObjects[0]['cid']]; // Stack of cids of map objects connected to nodes, which have been successfully hacked. Initially the starting node.

        // Run through all reachable map objects
        while (! empty($reachableMapObjects)) {
            $cid = array_pop($reachableMapObjects); // Get the cid of the hardware node, next to be attacked, from the top of the stack
            $mapObject = null;
            foreach ($allReachedMapObjects as $currentObject) { // Get the hardware object corresponding to the current cid
                if ($currentObject['cid'] == $cid) {
                    $mapObject = $currentObject;
                    break;
                }
            }
            if ($mapObject == null) {
                continue;
            }

            $hardwareObjectMitigations = $mapObject['settings']; // Mitigation flags of the hardware object set under settings

            if (array_key_exists($mapObject['cid'], $finalReport)) {
                $alreadyHacked = false;
                foreach ($finalReport[$mapObject['cid']]['sequences'] as $sequenceReport) {
                    if ($sequenceReport['success']) { // If the current hardware object has already been successfully hacked once, don't hack it again.
                        $alreadyHacked = true;
                        break;
                    }
                }
                if ($alreadyHacked) {
                    continue;
                }
            } else {
                $finalReport[$mapObject['cid']] = [
                    'MapObject' => $mapObject['cid'],
                ];
            }

            if ($allReachedMapObjects[0]['cid'] == $cid) { // The simulation starting node is always hacked
                $sequenceReport = [['hackerstep_sequence' => [[
                    'id' => 0,
                    'name' => 'Attack simulation starting node',
                    'mitigations' => [],
                    'missing_mitigation' => '',
                ]],
                    'success' => true]];

                $reachableMapObjects = array_merge($reachableMapObjects, $mapObject['neighbors']); // Add all directly connected hardware objects to the stack, so they may be hacked in later iterations.
            } else {
                // Try to execute every possible killchain per map object (Stops after one killchain is successful)
                $sequenceReport = [];
                foreach ($allPossibleKillchains as $sequence) {
                    // check for every step if the map objects mitigates the impact
                    $stepReport = [];
                    $killChainSuccessful = false; // if one killchain is successful stop
                    foreach ($sequence as $step) {
                        $stepImpactArray = $this->assess_step_impact($step, $hardwareObjectMitigations);
                        $stepImpact = $stepImpactArray[0];
                        $missingMitigation = $stepImpactArray[1]; // To show the user the reason, why this hardware object could be hacked

                        $stepReport[] = [
                            'id' => $step->id,
                            'name' => $step->name,
                            'mitigations' => $this->getMitigationsForAttack($step->name, 1 + 3 * $profileBaseline[$this->attackDomains[$step->name] - 1]), // Effort depends on the maximum profile baseline value for the domain of the attack step projected from [0, 3] to [0, 10]
                            'missing_mitigation' => $missingMitigation, // Device flag (i.E. hasPassword) is meant by mitigation here
                        ];

                        if ($stepImpact == 'none') {
                            // Step successfully mitigated
                            if (! in_array(['hackerstep_sequence' => $stepReport, 'success' => false], $sequenceReport)) {
                                $sequenceReport[] = [
                                    'hackerstep_sequence' => $stepReport,
                                    'success' => false,
                                ];
                            }
                            break;
                        }

                        if ($step->phase_id == $endPhase->id) {
                            // killchain reached phase 8 -> Device has been successfully hacked
                            $sequenceReport[] = [
                                'hackerstep_sequence' => $stepReport,
                                'success' => true,
                            ];
                            $killChainSuccessful = true;

                            $reachableMapObjects = array_merge($reachableMapObjects, $mapObject['neighbors']); // If the hardware object was hacked, add all directly connected hardware objects to the stack, so they may be hacked in later iterations.
                        }
                    }
                    if ($killChainSuccessful) {
                        break;
                    }
                }
            }

            $finalReport[$mapObject['cid']] = [
                'sequences' => $sequenceReport,
            ];
        }

        // Write the final report string to file
        File::put($filePath, json_encode($finalReport, JSON_PRETTY_PRINT));

        $response = [$finalReport, $filename]; // To be added to the map view without needing to reload reports from disk

        return response()->json($response, Response::HTTP_OK);
    }


    public function assess_step_impact($step, $mitigations)
    {
        /*
            calculates the final impact of a hackerattack step.
            the impact starts as high if a mitigation match the impact is lowered to medium
            if a second mitigation matches the impact goes down to none
            only exception to this is the firewall mitigation, here the impact directly goes down to none.
        */

        //TODO: save this mapping to a global accassable place where it can be accessed and changed on runtime (Database?)
        $stepIdMitigationMapping = [
            1 => ['hasEncryption', 'hasFirewall'],
            2 => ['hasFirewall', 'hasMemoryPassword'],
            3 => ['hasFirewall', 'hasUserManagement', 'hasMemoryPassword', 'hasPassword', 'hasBackup'],
            4 => ['hasBackup'],
            5 => ['hasBackup', 'hasEncryption', 'hasMemoryPassword', 'hasFirewall', 'hasPassword', 'hasUserManagement'],
            6 => ['hasPassword', 'hasFirewall', 'hasBackup'],
            7 => ['hasUserManagement'],
            8 => ['hasEncryption', 'hasFirewall', 'hasPassword', 'hasBackup', 'hasUserManagement', 'hasMemoryPassword'],
            9 => ['hasBackup', 'hasUserManagement', 'hasPassword', 'hasFirewall'],
            10 => ['hasUserManagement', 'hasFirewall', 'hasBackup', 'hasPassword', 'hasEncryption', 'hasMemoryPassword'],
            11 => ['hasEncryption', 'hasPassword', 'hasFirewall', 'hasMemoryPassword'],
            12 => ['hasPassword', 'hasMemoryPassword'],
            13 => ['hasBackup', 'hasEncryption', 'hasMemoryPassword', 'hasUserManagement', 'hasFirewall', 'hasPassword'],
            14 => ['hasMemoryPassword', 'hasUserManagement', 'hasEncryption', 'hasFirewall', 'hasPassword'],
            15 => ['hasEncryption', 'hasPassword', 'hasFirewall', 'hasUserManagement'],
            16 => ['hasEncryption'],
            17 => ['hasBackup'],
            18 => ['hasMemoryPassword', 'hasPassword'],
            19 => ['hasEncryption', 'hasMemoryPassword'],
            20 => ['hasEncryption'],
            21 => ['hasEncryption', 'hasMemoryPassword', 'hasUserManagement', 'hasPassword', 'hasBackup'],
            22 => ['hasEncryption'],
            23 => ['hasFirewall'],
            24 => ['hasMemoryPassword', 'hasFirewall', 'hasBackup'],
            25 => ['hasFirewall'],
            26 => ['hasFirewall', 'hasEncryption', 'hasBackup'],
            27 => ['hasMemoryPassword', 'hasPassword', 'hasBackup', 'hasEncryption', 'hasUserManagement', 'hasFirewall'],
            28 => ['hasMemoryPassword', 'hasFirewall'],
            29 => ['hasEncryption', 'hasPassword'],
            30 => ['hasPassword', 'hasMemoryPassword', 'hasEncryption', 'hasBackup', 'hasUserManagement', 'hasFirewall'],
            31 => ['hasPassword', 'hasEncryption', 'hasFirewall', 'hasUserManagement', 'hasBackup'],
            32 => ['hasMemoryPassword', 'hasFirewall', 'hasEncryption'],
            33 => ['hasPassword', 'hasBackup'],
            34 => ['hasUserManagement', 'hasMemoryPassword', 'hasEncryption'],
            35 => ['hasPassword', 'hasMemoryPassword', 'hasFirewall', 'hasEncryption', 'hasBackup'],
            36 => ['hasPassword'],
            37 => ['hasEncryption'],
            38 => ['hasUserManagement', 'hasBackup', 'hasFirewall', 'hasPassword', 'hasMemoryPassword'],
        ];

        $stepImpact = 'high';
        if ($mitigations['hasFirewall']) {
            return ['none', ''];
        }

        $stepMitigations = $stepIdMitigationMapping[$step->id];

        $trueMitigations = array_filter($mitigations);
        foreach (array_keys($trueMitigations) as $mitigation) {
            if (in_array($mitigation, $stepMitigations)) {
                $stepImpact = ($stepImpact == 'medium') ? 'none' : 'medium';
            }

            if ($stepImpact == 'none') {
                return ['none', ''];
            }
        }

        return [$stepImpact, '<li>'.implode('</li><li>', array_diff($stepMitigations, $trueMitigations)).'</li>'];
    }

    /**
     * Load and return a previously generated hacker attack report
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function load_report(Request $request)
    {
        $filename = $request->input('filename');
        $path = storage_path('app/reports/'.$filename);

        if (File::exists($path)) {
            $contents = File::get($path);
            $decodedContent = json_decode($contents, true);

            return response()->json($decodedContent, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'File not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Fetch and cache the MITRE data for use in simulations
     *
     * @return void
     */
    private function fetchMitreData()
    {
        $localFileDir = 'downloads';
        $localFilePath = $localFileDir.'/enterprise-attack.json';
        $jsonData = null;

        if (Storage::has($localFilePath) && Storage::lastModified($localFilePath) >= strtotime('-1 week')) {
            // If cached file is not older than 24 h us it, otherwise fetch new.

            $jsonData = Storage::get($localFilePath);
        } else {

            if (! Storage::exists($localFileDir)) {
                Storage::makeDirectory($localFileDir); //creates directory
            }

            $jsonUrl = 'https://raw.githubusercontent.com/mitre/cti/master/enterprise-attack/enterprise-attack.json';

            // Retrieve JSON-Data
            $jsonData = file_get_contents($jsonUrl);

            Storage::put($localFilePath, $jsonData);

        }

        // Check for correct json retrieval
        if ($jsonData === false) {
            exit('Error while loading JSON data');
        }

        // Convert JSON-Data to PHP-Array
        $this->mitreData = json_decode($jsonData, true);

        // Check for correct conversion
        if ($this->mitreData === null) {
            exit('Error while decoding JSON data');
        }

    }

    /**
     * Retrieve possible mitigations for a given attack, considering the effort required
     *
     * @param $attackName
     * @param $maxEffort
     * @return array|null
     */
    public function getMitigationsForAttack($attackName, $maxEffort = 10): ?array
    {
        $attackId = null;
        $mitigations = [];

        // Check if attack with current id can be found
        foreach ($this->mitreData['objects'] as $object) {
            if ($object['type'] === 'attack-pattern' && $object['name'] === $attackName) {
                $attackId = $object['id'];
                break;
            }
        }

        if ($attackId === null) {
            return null;
        }

        // Browse all mitigation for the current attack
        foreach ($this->mitreData['objects'] as $object) {
            if ($object['type'] === 'relationship' && $object['relationship_type'] === 'mitigates' && $object['target_ref'] === $attackId) {
                $mitigationId = $object['source_ref'];

                // Retrieve mitigation details
                foreach ($this->mitreData['objects'] as $mitigation) {
                    if ($mitigation['type'] === 'course-of-action' && $mitigation['id'] === $mitigationId && $mitigation['name'] != 'Do Not Mitigate') {

                        $curMitigationEffort = $this->mitigationEfforts[$mitigation['name']];

                        if ($curMitigationEffort <= $maxEffort) {
                            $mitigations[] = [
                                'name' => $mitigation['name'],
                                'description' => $mitigation['description'],
                                'effort' => $curMitigationEffort,
                            ];
                        }
                    }
                }
            }
        }

        return $mitigations;
    }

    // Which attack method belongs to which cybersec domain (1: NETWORK SECURITY, 2: SECURE CONNECTIVITY/REMOTE ACCESS, 3: OT SECURITY, 4: DATA SECURITY, 5: SUPPLY CHAIN SECURITY) (Source: ChatGPT)
    protected $attackDomains = [
        'Active Scanning' => 1,
        'Gather Victim Host Information' => 1,
        'Gather Victim Network Information' => 1,
        'Exploit Public-Facing Application' => 1,
        'Inter-Process Communication' => 1,
        'Adversary-in-the-Middle' => 1,
        'Brute Force' => 1,
        'External Remote Services' => 2,
        'Acquire Access' => 2,
        'Cloud Administration Command' => 2,
        'Drive-by Compromise' => 2,
        'Create Account' => 2,
        'Account Manipulation' => 2,
        'Forced Authentication' => 2,
        'Command and Scripting Interpreter' => 3,
        'Container Administration Command' => 3,
        'Deploy Container' => 3,
        'BITS Jobs' => 3,
        'Abuse Elevation Control Mechanism' => 3,
        'Exploitation for Client Execution' => 3,
        'Content Injection' => 4,
        'Compromise Client Software Binary' => 4,
        'Exploitation for Credential Access' => 4,
        'Credentials from Password Stores' => 4,
        'Input Capture' => 4,
        'Forge Web Credentials' => 4,
        'Access Token Manipulation' => 4,
        'Execution Guardrails' => 4,
        'Develop Capabilities' => 5,
        'Boot or Logon Autostart Execution' => 5,
        'Create or Modify System Process' => 5,
        'Domain Policy Modification' => 5,
        'File and Directory Permissions Modification' => 5,
        'Hide Artifacts' => 5,
        'Hijack Execution Flow' => 5,
        'Boot or Logon Initialization Scripts' => 5,
        'Browser Extensions' => 5,
    ];

    // Mitigation Efforts on a scale between 1 and 10 (Source: ChatGPT)
    protected $mitigationEfforts = [
        'Account Use Policies' => 3,
        'Active Directory Configuration' => 6,
        'Antivirus/Antimalware' => 4,
        'Application Developer Guidance' => 4,
        'Application Isolation and Sandboxing' => 6,
        'Audit' => 5,
        'Behavior Prevention on Endpoint' => 7,
        'Boot Integrity' => 7,
        'Code Signing' => 6,
        'Credential Access Protection' => 6,
        'Data Backup' => 5,
        'Data Loss Prevention' => 7,
        'Disable or Remove Feature or Program' => 4,
        'Do Not Mitigate' => 0,
        'Encrypt Sensitive Information' => 6,
        'Environment Variable Permissions' => 4,
        'Execution Prevention' => 6,
        'Exploit Protection' => 7,
        'Filter Network Traffic' => 6,
        'Limit Access to Resource Over Network' => 5,
        'Limit Hardware Installation' => 4,
        'Limit Software Installation' => 4,
        'Multi-factor Authentication' => 4,
        'Network Intrusion Prevention' => 7,
        'Network Segmentation' => 8,
        'Operating System Configuration' => 5,
        'Password Policies' => 4,
        'Pre-compromise' => 6,
        'Privileged Account Management' => 7,
        'Privileged Process Integrity' => 6,
        'Remote Data Storage' => 5,
        'Restrict File and Directory Permissions' => 4,
        'Restrict Library Loading' => 5,
        'Restrict Registry Permissions' => 4,
        'Restrict Web-Based Content' => 4,
        'Software Configuration' => 5,
        'SSL/TLS Inspection' => 6,
        'Threat Intelligence Program' => 7,
        'Update Software' => 4,
        'User Account Control' => 4,
        'User Account Management' => 5,
        'User Training' => 3,
        'Vulnerability Scanning' => 5,
    ];
}
