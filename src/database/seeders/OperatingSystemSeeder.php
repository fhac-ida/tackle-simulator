<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use Illuminate\Database\Seeder;

class OperatingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operatingSystems = [
            ['name' => 'Windows'],
            ['name' => 'Mac'],
            ['name' => 'Linux Arch'],
            ['name' => 'Linux Ubuntu'],
            ['name' => 'Linux Fedora'],
            ['name' => 'Linux CentOS'],
            ['name' => 'Linux Mint'],
            // Add more operating systems as needed
        ];

        OperatingSystem::insert($operatingSystems);
    }
}
