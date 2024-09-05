<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Seeder;

class Question_AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ['name' => 'Company Profile'],
            ['name' => 'Network security'],
            ['name' => 'Device Connectivity Maturity'],
            ['name' => 'PLC Management Maturity'],
            ['name' => 'Data, People&culture security'],
            ['name' => 'supply sec and NIS2 compliance'],

        ];

        $questions = [
            //Category 1
            ['question' => 'Please select your company size', 'category_id' => '1'],
            ['question' => 'Please select your sector', 'category_id' => '1'],
            ['question' => 'Is your company providing direct services to customers', 'category_id' => '1'],
            ['question' => 'Does your company exchange sensitive data with customers?', 'category_id' => '1'],

            //Category 2
            ['question' => 'Please select, what the status of your network documentation is', 'category_id' => '2'],
            ['question' => 'Please select, what the status of your network segregation is', 'category_id ' => '2'],
            ['question' => 'Please choose the current status of your firewall configuration.', 'category_id' => '2'],
            ['question' => 'Please specify the level of your network monitoring setup.', 'category_id' => '2'],
            ['question' => 'Please specify the governance policies in place to support network security.', 'category_id' => '2'],

            //Category 3
            ['question' => 'Please specify, how you specify connected devices in your network.', 'category_id' => '3'],
            ['question' => 'Please specify, how you monitor connected devices in your network.', 'category_id' => '3'],
            ['question' => 'Please specify, how you adopted least privilege principle for your connected assets.', 'category_id' => '3'],
            ['question' => 'Please specify, how you adopted zero trust policy and how access control is implemented for your connected assets.', 'category_id' => '3'],
            ['question' => 'Please specify, how you manage updates and vulnerabilities.', 'category_id' => '3'],
            ['question' => 'Please specify, how do you manage remote access to connected devices.', 'category_id' => '3'],

            //Category 4
            ['question' => 'Please specify, how you manage your PLC/HMI programming.
            (Please make sure that everything applies).', 'category_id' => '4'],
            ['question' => 'Please specify, how you manage your PLC/HMI.(Please make sure that everything applies).', 'category_id' => '4'],
            ['question' => 'Please specify, how the lifecycle of your PLC/HMI is managed.(Please make sure that everything applies).', 'category_id' => '4'],
            ['question' => 'Please specify, how the data access on your PLCs is managed (Push/pull).(Please make sure that everything applies).', 'category_id' => '4'],
            ['question' => 'Please specify, how the data access on your IIoT devices is managed (Push/pull).(Please make sure that everything applies).', 'category_id' => '4'],

            //Category 5
            ['question' => 'Please specify the level of access control in your company.
            (Please make sure that everything applies).', 'category_id' => '5'],
            ['question' => 'Please specify, how do you classify data in your company.
            (Please make sure that everything applies).', 'category_id' => '5'],
            ['question' => 'Please specify, how do you store data in your company.
            (Please make sure that everything applies).', 'category_id' => '5'],
            ['question' => 'Please specify, how do you exchange data in your company and with customers.
            (Please make sure that everything applies).', 'category_id' => '5'],
            ['question' => 'Please specify, how the data privacy is supported in your company and with customers.
            (Please make sure that everything applies).', 'category_id' => '5'],
            ['question' => 'Please specify, the actions for supporting  cybersecurity culture in your company.
            (Please make sure that everything applies).', 'category_id' => '5'], //<-- Next Category; Incident response in category 2

            //Category 6
            ['question' => 'Please specify your incident response and recovery plan.
            (Please make sure that everything applies).', 'category_id' => '6'], //<-- this Category; repeate Incident response
            ['question' => 'Please specify, the level of supply chain documentation in your company.
            (Please make sure that everything applies).', 'category_id' => '6'],
            ['question' => 'Please specify, the supply chain security requirements and contractual obligations in your company.
            (Please make sure that everything applies).', 'category_id' => '6'],
            ['question' => 'Please specify, how do you conduct security audits and risk assessments of your partners.
            (Please make sure that everything applies).', 'category_id' => '6'],
            ['question' => 'Please specify the level of visibility into external connection.
            (Please make sure that everything applies).', 'category_id' => '6'],
            ['question' => 'Please specify the level of NIS2 compliance
            (Please make sure that everything applies).', 'category_id' => '6'],
            ['question' => 'Please specify how do you analyse the vulnerabilities in the updates.
            (Please make sure that everything applies).', 'category_id' => '6'],
        ];

        $answers = [
            //Category 1
            ['answer' => '<=10', 'question_id' => '1'],
            ['answer' => '>10, <=50', 'question_id' => '1'],
            ['answer' => '>50, <=250', 'question_id' => '1'],

            ['answer' => 'Essential (Waste water, Drinking Water, Health, Energy, Transport, Digital infrastructures (including ISP & cloud), Banking, Financial market infrastructure, ICT-Service Management (B2B), Public administration, Space)', 'question_id' => '2'],
            ['answer' => 'Important (Manufacturing (Equipment), Manufacturing (production and distribution of chemicals), Postal and courier services, Digital providers, Research, Food production & distribution, Waste management)', 'question_id' => '2'],
            ['answer' => 'Non-important (Not covered by the above)', 'question_id' => '2'],

            ['answer' => 'Yes, including essential customers', 'question_id' => '3'],
            ['answer' => 'Yes, including important but only non-essential customers', 'question_id' => '3'],
            ['answer' => 'Yes, only to non-important customers', 'question_id' => '3'],
            ['answer' => 'No', 'question_id' => '3'],

            ['answer' => 'Yes', 'question_id' => '4'],
            ['answer' => 'No', 'question_id' => '4'],

            //Category 2
            ['answer' => 'Absent', 'question_id' => '5'],
            ['answer' => 'Basic network documentation in place', 'question_id' => '5'],
            ['answer' => '+ Network documentation is regularly updated', 'question_id' => '5'],
            ['answer' => '+ asset inventory (network scan) tool is used for documenting network AND detailed documentation present such as access control policy and threat modelling document', 'question_id' => '5'],

            ['answer' => 'Absent (flat network)', 'question_id' => '6'],
            ['answer' => 'Office and production network are separated AND mobile, guest and office network separated', 'question_id' => '6'],
            ['answer' => 'legacy and remotely connected machines in separate VLANs', 'question_id' => '6'],
            ['answer' => '+ micro segmentation in place in accordance with risk analysis AND segregation is configured and regularly updated for segments', 'question_id' => '6'],

            ['answer' => 'No firewall', 'question_id' => '7'],
            ['answer' => 'Presence of firewall', 'question_id' => '7'],
            ['answer' => 'Next gen or industrial grade firewall present and regularly updated AND no external devices allowed; guest accounts are temporary AND industrial switches in place.', 'question_id' => '7'],
            ['answer' => '+ centrally managed AND access policy is in accordance with firewall configuration AND the settings are gone over regularly.', 'question_id' => '7'],

            ['answer' => 'No network monitoring system in place', 'question_id' => '8'],
            ['answer' => 'Regular monitoring/basic system for network monitoring in place AND network alerts are set up', 'question_id' => '8'],
            ['answer' => '+ continuous monitoring in place', 'question_id' => '8'],
            ['answer' => '+ log analysis AND specific security monitoring tool is used AND dedicated IPS/IDS in place', 'question_id' => '8'],

            ['answer' => 'No procedures for incident response, training and audits.', 'question_id' => '9'],
            ['answer' => 'Incident response document in place AND incident recovery procedure in place', 'question_id' => '9'],
            ['answer' => '+ regular network security trainings', 'question_id' => '9'],
            ['answer' => '+ regular audits and pentesting', 'question_id' => '9'],

            //Category 3
            ['answer' => 'No device specification', 'question_id' => '10'],
            ['answer' => 'Device documentation in place (firmware version, configuration, connection type ) AND protocol and connection type are clearly specified', 'question_id' => '10'],
            ['answer' => 'Device documentation in place and regularly updated AND connection type including protocol, service, port, connection time is identified and documented for each device', 'question_id' => '10'],
            ['answer' => '+ use asset inventory (network scan) tool for documenting connected devices AND comprehensive documentation of policy is in place AND policies are established based on zero-trust principle: no one is trusted by default.', 'question_id' => '10'],

            ['answer' => 'No device monitoring', 'question_id' => '11'],
            ['answer' => 'Regular device monitoring in place', 'question_id' => '11'],
            ['answer' => '+ monitoring external connections with a dedicated tool/solution AND security alerts are set up on external connections', 'question_id' => '11'],
            ['answer' => '+ anomaly detection solution in place AND network monitoring is continuous, based on machine learning principles AND alerts are raised on abnormal connections and packets', 'question_id' => '11'],

            ['answer' => 'No specification of access restriction for the connected devices OR no contractual basis for the vendors or service providers.', 'question_id' => '12'],
            ['answer' => 'Ports are restricted for each connected device AND connections to legacy devices are restricted based on minimum time of connection AND external connections from providers are not allowed 24/7', 'question_id' => '12'],
            ['answer' => '+ central tool for managing connections and their visibility AND connections to legacy devices are strictly limited and monitored based on granular access control AND external connections are managed explicitly (time, port, service, user) on a contractual basis and shared responsability (customer-provider)', 'question_id' => '12'],
            ['answer' => '+ Least privilege principle implemented in the complete network AND each connection is allowed only with accordance with policy and Kipling granular access principles: who? what? when? where? why? how?', 'question_id' => '12'],

            ['answer' => 'No firewall, common credentials, no policy', 'question_id' => '13'],
            ['answer' => 'Using firewall for limiting access to connected devices AND restrict ftp, USB, floppy disk AND legacy protocols such as modbus, telnet, Serial to Ethernet (i.e. IOLAN+232) are not exposed to network AND consider specific VLAN, closed ports, managed access on a firewall or a specific device AND providers access devices through specific ports on the firewall, not through USB or floppy disk.', 'question_id' => '13'],
            ['answer' => '+ using industrial grade modern firewall or nextgen firewall AND credentials are not shared for the devices, tackled manually when not possible to do it in centralized way AND credentials are kept securely and removable media policy in place AND granular access control to the legacy devices enforced on a firewall AND for providers, external access is centrally managed and contractually specified.', 'question_id' => '13'],
            ['answer' => '+ comprehensive zero-trust policy defining all services, entities, users who can access to the connected device in accordance with least privilege AND access rights manager and group policy (AD, Confluence, CRM) in place enforced on a firewall AND providers explicity use least privilege principle in connection specification.', 'question_id' => '13'],

            ['answer' => 'No regular updates of connected devices OR legacy machines and software are accessible from the network', 'question_id' => '14'],
            ['answer' => 'Regular update firmware of connected device AND separate legacy machines managed by Win2000, WinXP, Win7 from network', 'question_id' => '14'],
            ['answer' => '+ visibility into update or trusted source of update. In other words, your vendors provide a way to validate update for customers Regularly verify vulnerabilities, patches and connection setting to legacy machines AND restrict access to mitigate the risk if update is not possible.', 'question_id' => '14'],
            ['answer' => '+ patch management solution in place AND enhanced visibility of connection if update is not possible', 'question_id' => '14'],

            ['answer' => 'No limitations', 'question_id' => '15'],
            ['answer' => 'Identification with SHARED login and password AND communication is site to site encrypted', 'question_id' => '15'],
            ['answer' => 'Identification with PERSONAL login and password AND communication is site to site encrypted AND admin audit possible AND limitations on what the remote access side can see/access, possibility to view (audit) remote access.', 'question_id' => '15'],
            ['answer' => 'Identification with PERSONAL login and password AND communication is site to site encrypted AND admin can manage the session: audit, interrupt, initiate from the inside AND limitations on what the remote access side can see/access, possibility to view (audit) remote access AND 2FA used, wherever possible.', 'question_id' => '15'],

            //Category 4
            ['answer' => 'No limitations.', 'question_id' => '16'],
            ['answer' => 'No adhoc reprogramming allowed (scheduled) AND need permission by OT manager to update.', 'question_id' => '16'],
            ['answer' => '+ code is version controlled ( eg. Git) AND PLCs are enclosed in cabinet (need key to open)', 'question_id' => '16'],
            ['answer' => '+ not allowed to  directly connect engineering PC to PLC AND reprogramming must be done from secured jump host in DMZ', 'question_id' => '16'],

            ['answer' => 'No limitations.', 'question_id' => '17'],
            ['answer' => 'Identification with SHARED login and password, including remote access (eg. VNC)', 'question_id' => '17'],
            ['answer' => 'Identification with PERSONAL login and password or external PERSONAL key (eg. rfid), including remote access (eg. VNC)', 'question_id' => '17'],
            ['answer' => '+ communication between PLC & HMI is end-to-end encrypted.', 'question_id' => '17'],

            ['answer' => 'No particular actions.', 'question_id' => '18'],
            ['answer' => 'Patch new firmware at regular interval.', 'question_id' => '18'],
            ['answer' => '+ monitor CVEs and patch updates as soon as possible.', 'question_id' => '18'],
            ['answer' => '+ reinstall firmware (verify Hash) for new device AND for decommisioning device use factory reset (remove stored credetials) AND destroy unused and broken devices (onboard flash) (remove stored credentials)', 'question_id' => '18'],

            ['answer' => 'No limitations.', 'question_id' => '19'],
            ['answer' => 'Access only allowed after checking credentials (login, pw or keys), for all services', 'question_id' => '19'],
            ['answer' => '+ credentials set per user/service AND communication is end-to-end encrypted AND all not used ports are closed', 'question_id' => '19'],
            ['answer' => '+ all connections are initiated from the inside (Push only).', 'question_id' => '19'],

            ['answer' => 'No limitations.', 'question_id' => '20'],
            ['answer' => 'Access only allowed after checking credentials (login, pw or keys), for all services', 'question_id' => '20'],
            ['answer' => '+ credentials set per user/service AND communication is end-to-end encrypted AND all not used ports are closed.', 'question_id' => '20'],
            ['answer' => '+ all connections are initiated from the inside (Push only) AND OTA system in place.', 'question_id' => '20'],

            //Category 5
            ['answer' => 'Authentication with username password or security key, absent of password policy, including password or key renewal', 'question_id' => '21'],
            ['answer' => 'Authentication with username & password or security keys AND Sufficient password complexity policy including password renewal(e.g., every 6 months) AND Access should be restricted based on role of people in an organisation', 'question_id' => '21'],
            ['answer' => '+ Multifactor authentication AND Fine-grain access control with least privilege principle AND Data integrity and access tracing and tracking', 'question_id' => '21'],
            ['answer' => '+ Access log auditing AND Smart access control tool with alert system when abnormal activities detected', 'question_id' => '21'],

            ['answer' => 'No classification.', 'question_id' => '22'],
            ['answer' => 'Classify data based on their level of criticality. For example, employees data is kept separately from financial data of company.', 'question_id' => '22'],
            ['answer' => '+ Fine-grained data classification based on criticality level such as For example: public, internal, confidential; non-critical, business-critical, personal or similar AND Do risk assessment of each data category and implement solutions to address them', 'question_id' => '22'],
            ['answer' => '+ Highly confidential data should be kept in a separate physical storage or network from normal data and having more stringent access control to it', 'question_id' => '22'],

            ['answer' => 'Data stored in the insecure network or storage OR No data backup OR No proper access control mechanism in place for control access to data or to the physical device storing data.', 'question_id' => '23'],
            ['answer' => 'Existence of data backup, at least, a copy of data in a separate device AND Existence of Data backup policy AND Existence of access control to data storage and limit physical access to device storing data, if applicable (exception for Cloud storage)', 'question_id' => '23'],
            ['answer' => '+ Following standard backup policy 3-2-2 AND Data on storage are protected with sufficient security mechanisms such as encrypting data before storing', 'question_id' => '23'],
            ['answer' => '+ Existence of data retention policy for both normal and personal data AND Having very secure network infrastructure with advanced protection tool either on premise or Cloud storage AND Having advanced tools for data access control AND Performing access auditing and having periodic report to storage access and management', 'question_id' => '23'],

            ['answer' => 'Exchange data in an unsecure medium (e.g., with unprotected flash drive) OR Using email for data exchange without proper protection to data, for example, send data without password protected through email', 'question_id' => '24'],
            ['answer' => 'Using a secure communication medium for data exchange AND Always password protected data, especially confidential data, when exchange through email or Flash', 'question_id' => '24'],
            ['answer' => '+ Using secure tools for sharing data with proper access control. E.g., onedrive or other data sharing space AND Using secure protocol for data exchange', 'question_id' => '24'],
            ['answer' => '+ Having data exchange history and it is traceable AND Existence of formal data exchange auditing performed by security department', 'question_id' => '24'],

            ['answer' => 'Personal data is stored in unsecure storage without proper access control mechanism in place OR No control on data processing and check whether or not it complies with purpose consented by data owner', 'question_id' => '25'],
            ['answer' => 'Personal data is stored in protected storage and only authorized people are allowed to access AND Data is processed in accordance with its intended purpose', 'question_id' => '25'],
            ['answer' => '+ Existence of data retention policy as defined in GDPR.', 'question_id' => '25'],
            ['answer' => '+ Existence of mechanism to ensure rights to be forgotten AND Existence of tools for data access auditing in case of data breach AND Existence of data access history', 'question_id' => '25'],

            //Category 6 hier???
            ['answer' => 'Non-existence of CS training program.', 'question_id' => '26'],
            ['answer' => 'There is a CS training with a minimum of one per year AND There are sufficient topics to be covered for at least about phishing and ransomware', 'question_id' => '26'],
            ['answer' => '+ Different topics must be covered for the CS training from network to data security AND Existence of CS program in the company with clear duty assignment AND Existence of CS security teams', 'question_id' => '26'],
            ['answer' => '+ Organized implementation of CS program AND Measure the success and adapt CS program to the needs of the company cyber security posture', 'question_id' => '26'],

            ['answer' => 'No incident response and recovery plan.', 'question_id' => '27'],
            ['answer' => 'Existence of incident response plan AND Document possible incidents and (e.g., ransomware recovery plan)', 'question_id' => '27'],
            ['answer' => '+ For each identified incident, define a plan to mitigate AND Define a plan to execute in case of an incident AND Define a recovery plan for each identified incident', 'question_id' => '27'],
            ['answer' => '+ Assess/reassess the existing incident recovery plan regularly AND Improve the existing plan if it is found ineffective or has security flaw', 'question_id' => '27'],

            //Category 7 hier???
            ['answer' => 'absent', 'question_id' => '28'],
            ['answer' => 'A document with all supply chain partners, machine builders, vendors,  external parties having access to the network, their access rights, accounts AND For providers:  a document with all customers, access rights to their networks and accounts.', 'question_id' => '28'],
            ['answer' => '+ Supply chain documentation regularly updated.', 'question_id' => '28'],
            ['answer' => '+ Use dedicated tool for documenting the external connection AND Access control policy based on least privilege principle and zero trust in place', 'question_id' => '28'],

            ['answer' => 'absent (no security requirements with the partners).', 'question_id' => '29'],
            ['answer' => 'Contract with machine builders, vendors, providers mentions responsibility in the case of security breach', 'question_id' => '29'],
            ['answer' => '+ Contract mentions clear requirements and guidelines to the external connection, account rights, visibility, supporting the appropriate maturity level', 'question_id' => '29'],
            ['answer' => '+ Contract includes maturity validation criteria and is regularly updated', 'question_id' => '29'],

            ['answer' => 'No risk assessment of the supply chain partners', 'question_id' => '30'],
            ['answer' => 'Minimal list of questions (buyer`s guide) to the vendors, machine builders and service providers', 'question_id' => '30'],
            ['answer' => '+ Risk assessment is conducted for all supply chain interactions (how secure is this communicaiton/procedure/update/product?)', 'question_id' => '30'],
            ['answer' => '+ Regular audit is conducted for all supply chain partners (along with internal audit)', 'question_id' => '30'],

            ['answer' => 'No visibility into external connections', 'question_id' => '31'],
            ['answer' => 'Notified when there is a remote connection from provider, vendor, machine builder', 'question_id' => '31'],
            ['answer' => '+ Continuous monitoring of remote connection in place including the protocol, data packets, user account etc.', 'question_id' => '31'],
            ['answer' => '+ Specific security monitoring tool is used AND Dedicated IPS/IDS', 'question_id' => '31'],

            ['answer' => 'No awareness of NIS2 compliance', 'question_id' => '32'],
            ['answer' => 'Incident response procedure in place AND Clear understanding of NIS2 obligations for your company (essential, important, not applies) AND clear understanding of NIS2 obligations of all supply chain partners', 'question_id' => '32'],
            ['answer' => '+ Roadmap to implementing NIS2 in place', 'question_id' => '32'],
            ['answer' => '+ NIS2 compliance', 'question_id' => '32'],

            ['answer' => 'No vulnerability analysis', 'question_id' => '33'],
            ['answer' => 'Basic vulnerability scan has been performed at least once', 'question_id' => '33'],
            ['answer' => '+ Regular vulnerability scan of the updates and software systems. Regular verification of the updates.', 'question_id' => '33'],
            ['answer' => '+ Continuous vulnerability scanning in place. Software updates are validated with signature.', 'question_id' => '33'],
        ];

        Category::insert($categories);
        Question::insert($questions);
        foreach ($answers as $lines) {
            Answer::insert($lines);
        }
    }
}
