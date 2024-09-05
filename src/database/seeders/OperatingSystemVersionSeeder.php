<?php

namespace Database\Seeders;

use App\Models\OperatingSystemVersion;
use Illuminate\Database\Seeder;

class OperatingSystemVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operatingSystemVersions = [
            // Windows versions
            [
                'version' => 'Windows 3.1',
                'release_date' => '1992-04-06',
                'end_of_service' => '2001-12-31',
                'operatingsystem_id' => 1, // Assuming Windows has the ID 1 in the operatingsystems table
            ],
            [
                'version' => 'Windows 95',
                'release_date' => '1995-08-24',
                'end_of_service' => '2001-12-31',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 98',
                'release_date' => '1998-06-25',
                'end_of_service' => '2006-07-11',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows XP',
                'release_date' => '2001-10-25',
                'end_of_service' => '2014-04-08',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 7',
                'release_date' => '2009-10-22',
                'end_of_service' => '2020-01-14',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10',
                'release_date' => '2015-07-29',
                'end_of_service' => null, // No EOL specified for this example
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1511 (Threshold 2)',
                'release_date' => '2015-11-10',
                'end_of_service' => '2017-10-10',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1607 (Anniversary Update)',
                'release_date' => '2016-08-02',
                'end_of_service' => '2018-04-10',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1703 (Creators Update)',
                'release_date' => '2017-04-05',
                'end_of_service' => '2019-10-08',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1709 (Fall Creators Update)',
                'release_date' => '2017-10-17',
                'end_of_service' => '2019-04-09',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1803 (April 2018 Update)',
                'release_date' => '2018-04-30',
                'end_of_service' => '2019-11-12',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1809 (October 2018 Update)',
                'release_date' => '2018-11-13',
                'end_of_service' => '2020-11-10',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1903 (May 2019 Update)',
                'release_date' => '2019-05-21',
                'end_of_service' => '2020-12-08',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 1909 (November 2019 Update)',
                'release_date' => '2019-11-12',
                'end_of_service' => '2021-05-11',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 2004 (May 2020 Update)',
                'release_date' => '2020-05-27',
                'end_of_service' => '2021-12-14',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 20H2 (October 2020 Update)',
                'release_date' => '2020-10-20',
                'end_of_service' => '2022-05-10',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 10 21H1 (May 2021 Update)',
                'release_date' => '2021-05-18',
                'end_of_service' => '2022-12-13',
                'operatingsystem_id' => 1,
            ],
            // Windows 11 versions
            [
                'version' => 'Windows 11',
                'release_date' => '2021-10-05',
                'end_of_service' => null, // No EOL specified for this example
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 11 21H2 (October 2021 Update)',
                'release_date' => '2021-10-05',
                'end_of_service' => '2024-10-14',
                'operatingsystem_id' => 1,
            ],
            [
                'version' => 'Windows 11 22H2 (Future Update)', // Replace with actual version name and release date when available
                'release_date' => '2022-XX-XX', // Replace with actual release date when available
                'end_of_service' => null, // No EOL specified for this example
                'operatingsystem_id' => 1,
            ],
            // Linux distributions and versions
            [
                'version' => 'Arch Linux 2021.10.01',
                'release_date' => '2021-10-01',
                'end_of_service' => null, // No EOL specified for this example
                'operatingsystem_id' => 3, // Assuming Linux Arch has the ID 3 in the operatingsystems table
            ],
            [
                'version' => 'Ubuntu 20.04 LTS',
                'release_date' => '2020-04-23',
                'end_of_service' => '2025-04-23',
                'operatingsystem_id' => 4, // Assuming Linux Ubuntu has the ID 4 in the operatingsystems table
            ],
            // Add more Linux versions as needed
            [
                'version' => 'Fedora 35',
                'release_date' => '2022-10-25',
                'end_of_service' => null, // No EOL specified for this example
                'operatingsystem_id' => 5, // Assuming Linux Fedora has the ID 5 in the operatingsystems table
            ],
            [
                'version' => 'CentOS 8.5',
                'release_date' => '2022-09-27',
                'end_of_service' => '2029-12-31',
                'operatingsystem_id' => 6, // Assuming Linux CentOS has the ID 6 in the operatingsystems table
            ],
            [
                'version' => 'Linux Mint 20.3',
                'release_date' => '2022-12-15',
                'end_of_service' => '2025-12-15',
                'operatingsystem_id' => 7, // Assuming Linux Mint has the ID 7 in the operatingsystems table
            ],

        ];

        //todo versionen ab september 2021 kann gpt leider nicht generieren und linux habe ich nicht ausgereizt, der kann bei bedarf noch mehr generieren

        OperatingSystemVersion::insert($operatingSystemVersions);
    }
}
