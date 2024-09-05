<?php

namespace Database\Seeders;

use App\Models\Preview\Hackerattackstep;
use App\Models\Preview\Phase;
use Illuminate\Database\Seeder;

class HackerStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create steps and connect them
        $stepData = [
            ['name' => 'Active Scanning', 'phase_id' => 1, 'next' => []],
            ['name' => 'Gather Victim Host Information', 'phase_id' => 1, 'next' => []],
            ['name' => 'Gather Victim Network Information', 'phase_id' => 1, 'next' => []],
            ['name' => 'Develop Capabilities', 'phase_id' => 2, 'next' => []],
            ['name' => 'Acquire Access', 'phase_id' => 2, 'next' => []],
            ['name' => 'Content Injection', 'phase_id' => 3, 'next' => []],
            ['name' => 'Drive-by Compromise', 'phase_id' => 3, 'next' => []],
            ['name' => 'Exploit Public-Facing Application', 'phase_id' => 3, 'next' => []],
            ['name' => 'External Remote Services', 'phase_id' => 3, 'next' => []],
            ['name' => 'Cloud Administration Command', 'phase_id' => 4, 'next' => []],
            ['name' => 'Command and Scripting Interpreter', 'phase_id' => 4, 'next' => []],
            ['name' => 'Container Administration Command', 'phase_id' => 4, 'next' => []],
            ['name' => 'Deploy Container', 'phase_id' => 4, 'next' => []],
            ['name' => 'Exploitation for Client Execution', 'phase_id' => 4, 'next' => []],
            ['name' => 'Inter-Process Communication', 'phase_id' => 4, 'next' => []],
            ['name' => 'Account Manipulation', 'phase_id' => 5, 'next' => []],
            ['name' => 'BITS Jobs', 'phase_id' => 5, 'next' => []],
            ['name' => 'Boot or Logon Autostart Execution', 'phase_id' => 5, 'next' => []],
            ['name' => 'Boot or Logon Initialization Scripts ', 'phase_id' => 5, 'next' => []],
            ['name' => 'Browser Extensions', 'phase_id' => 5, 'next' => []],
            ['name' => 'Compromise Client Software Binary', 'phase_id' => 5, 'next' => []],
            ['name' => 'Create Account', 'phase_id' => 5, 'next' => []],
            ['name' => 'Abuse Elevation Control Mechanism', 'phase_id' => 6, 'next' => []],
            ['name' => 'Access Token Manipulation', 'phase_id' => 6, 'next' => []],
            ['name' => 'Account Manipulation', 'phase_id' => 6, 'next' => []],
            ['name' => 'Create or Modify System Process', 'phase_id' => 6, 'next' => []],
            ['name' => 'Domain Policy Modification', 'phase_id' => 7, 'next' => []],
            ['name' => 'Execution Guardrails', 'phase_id' => 7, 'next' => []],
            ['name' => 'File and Directory Permissions Modification', 'phase_id' => 7, 'next' => []],
            ['name' => 'Hide Artifacts', 'phase_id' => 7, 'next' => []],
            ['name' => 'Hijack Execution Flow', 'phase_id' => 7, 'next' => []],
            ['name' => 'Adversary-in-the-Middle', 'phase_id' => 8, 'next' => []],
            ['name' => 'Brute Force', 'phase_id' => 8, 'next' => []],
            ['name' => 'Credentials from Password Stores', 'phase_id' => 8, 'next' => []],
            ['name' => 'Exploitation for Credential Access', 'phase_id' => 8, 'next' => []],
            ['name' => 'Forced Authentication', 'phase_id' => 8, 'next' => []],
            ['name' => 'Forge Web Credentials', 'phase_id' => 8, 'next' => []],
            ['name' => 'Input Capture', 'phase_id' => 8, 'next' => []],
        ];

        $stepData2 = [
            ['name' => 'Active Scanning', 'phase_id' => 1, 'next' => [4, 5]],
            ['name' => 'Gather Victim Host Information', 'phase_id' => 1, 'next' => [5, 4]],
            ['name' => 'Gather Victim Network Information', 'phase_id' => 1, 'next' => [4, 5]],
            ['name' => 'Develop Capabilities', 'phase_id' => 2, 'next' => [7, 9, 6, 8]],
            ['name' => 'Acquire Access', 'phase_id' => 2, 'next' => [6, 7, 8]],
            ['name' => 'Content Injection', 'phase_id' => 3, 'next' => [10, 11]],
            ['name' => 'Drive-by Compromise', 'phase_id' => 3, 'next' => [10, 14, 11, 12]],
            ['name' => 'Exploit Public-Facing Application', 'phase_id' => 3, 'next' => [15, 14]],
            ['name' => 'External Remote Services', 'phase_id' => 3, 'next' => [12, 10, 13, 15]],
            ['name' => 'Cloud Administration Command', 'phase_id' => 4, 'next' => [17, 22, 19]],
            ['name' => 'Command and Scripting Interpreter', 'phase_id' => 4, 'next' => [18, 20, 16, 17]],
            ['name' => 'Container Administration Command', 'phase_id' => 4, 'next' => [20, 21, 18, 16]],
            ['name' => 'Deploy Container', 'phase_id' => 4, 'next' => [20, 17, 18]],
            ['name' => 'Exploitation for Client Execution', 'phase_id' => 4, 'next' => [16, 17, 21]],
            ['name' => 'Inter-Process Communication', 'phase_id' => 4, 'next' => [18, 21, 19, 16]],
            ['name' => 'Account Manipulation', 'phase_id' => 5, 'next' => [25, 24]],
            ['name' => 'BITS Jobs', 'phase_id' => 5, 'next' => [26, 24, 23, 25]],
            ['name' => 'Boot or Logon Autostart Execution', 'phase_id' => 5, 'next' => [23, 26, 25, 24]],
            ['name' => 'Boot or Logon Initialization Scripts', 'phase_id' => 5, 'next' => [23, 25]],
            ['name' => 'Browser Extensions', 'phase_id' => 5, 'next' => [24, 23]],
            ['name' => 'Compromise Client Software Binary', 'phase_id' => 5, 'next' => [26, 25, 24, 23]],
            ['name' => 'Create Account', 'phase_id' => 5, 'next' => [26, 25, 24, 23]],
            ['name' => 'Abuse Elevation Control Mechanism', 'phase_id' => 6, 'next' => [29, 27]],
            ['name' => 'Access Token Manipulation', 'phase_id' => 6, 'next' => [29, 27, 31, 28]],
            ['name' => 'Account Manipulation', 'phase_id' => 6, 'next' => [29, 28, 31]],
            ['name' => 'Create or Modify System Process', 'phase_id' => 6, 'next' => [29, 28]],
            ['name' => 'Domain Policy Modification', 'phase_id' => 7, 'next' => [38, 32, 33, 34]],
            ['name' => 'Execution Guardrails', 'phase_id' => 7, 'next' => [35, 37, 38, 33]],
            ['name' => 'File and Directory Permissions Modification', 'phase_id' => 7, 'next' => [38, 36, 37, 32]],
            ['name' => 'Hide Artifacts', 'phase_id' => 7, 'next' => [36, 35, 33, 37]],
            ['name' => 'Hijack Execution Flow', 'phase_id' => 7, 'next' => [36, 38, 34]],
            ['name' => 'Adversary-in-the-Middle', 'phase_id' => 8, 'next' => []],
            ['name' => 'Brute Force', 'phase_id' => 8, 'next' => []],
            ['name' => 'Credentials from Password Stores', 'phase_id' => 8, 'next' => []],
            ['name' => 'Exploitation for Credential Access', 'phase_id' => 8, 'next' => []],
            ['name' => 'Forced Authentication', 'phase_id' => 8, 'next' => []],
            ['name' => 'Forge Web Credentials', 'phase_id' => 8, 'next' => []],
            ['name' => 'Input Capture', 'phase_id' => 8, 'next' => []],
        ];

        $stepDataX = [
            ['name' => 'Active Scanning', 'phase_id' => 1, 'next' => [3]], // IDs aus Phase 2
            ['name' => 'Gather Victim Host Information', 'phase_id' => 1, 'next' => [3, 4]],
            ['name' => 'Develop Capabilities', 'phase_id' => 2, 'next' => [5]], // IDs aus Phase 3
            ['name' => 'Acquire Access', 'phase_id' => 2, 'next' => [5, 6]],
            ['name' => 'Content Injection', 'phase_id' => 3, 'next' => [7]], // IDs aus Phase 4
            ['name' => 'Drive-by Compromise', 'phase_id' => 3, 'next' => [7, 8]],
            ['name' => 'Cloud Administration Command', 'phase_id' => 4, 'next' => [9]], // IDs aus Phase 5
            ['name' => 'Command and Scripting Interpreter', 'phase_id' => 4, 'next' => [9, 10]],
            ['name' => 'Account Manipulation', 'phase_id' => 5, 'next' => [11]], // IDs aus Phase 6
            ['name' => 'BITS Jobs', 'phase_id' => 5, 'next' => [11, 12]],
            ['name' => 'Abuse Elevation Control Mechanism', 'phase_id' => 6, 'next' => [13]], // IDs aus Phase 7
            ['name' => 'Access Token Manipulation', 'phase_id' => 6, 'next' => [13, 14]],
            ['name' => 'Domain Policy Modification', 'phase_id' => 7, 'next' => [15]], // IDs aus Phase 8
            ['name' => 'Execution Guardrails', 'phase_id' => 7, 'next' => [15, 16]],
            ['name' => 'Adversary-in-the-Middle', 'phase_id' => 8, 'next' => []], // Keine weiteren Phasen
            ['name' => 'Brute Force', 'phase_id' => 8, 'next' => []],
        ];

        $this->command->info('Step 1...');

        foreach ($stepData2 as $stepDatum) {
            $step = Hackerattackstep::create([
                'name' => $stepDatum['name'],
                'phase_id' => $stepDatum['phase_id'],
            ]);
        }

        $this->command->info('Step 2...');

        foreach ($stepData2 as $stepDatum) {
            $step = Hackerattackstep::where([
                'name' => $stepDatum['name'],
            ])->first();

            foreach ($stepDatum['next'] as $nextStepId) {
                $nextStep = Hackerattackstep::where('id', $nextStepId)->first();
                $step->nextSteps()->attach($nextStep);
            }
        }
    }
}
