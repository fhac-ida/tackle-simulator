<?php

namespace Database\Seeders;

use App\Models\Preview\Phase;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phase::create([
            'name' => 'Reconnaissance',
            'is_start_phase' => true,
            'step' => 1,
        ]);

        Phase::create([
            'name' => 'Resource Development',
            'step' => 2,
        ]);

        Phase::create([
            'name' => 'Initial Access',
            'step' => 3,
        ]);

        Phase::create([
            'name' => 'Execution',
            'step' => 4,
        ]);

        Phase::create([
            'name' => 'Persistence',
            'step' => 5,
        ]);

        Phase::create([
            'name' => 'Privilege Escalation',
            'step' => 6,
        ]);

        Phase::create([
            'name' => 'Defense Evasion',
            'step' => 7,
        ]);

        Phase::create([
            'name' => 'Credential Access',
            'is_end_phase' => true,
            'step' => 8,
        ]);
    }
}
