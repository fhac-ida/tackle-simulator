<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            MapSeeder::class,
            HardwareObjectSeeder::class,
            OperatingSystemSeeder::class,
            OperatingSystemVersionSeeder::class,
            PhaseSeeder::class,
            HackerStepSeeder::class,
            ScenarioSeeder::class,
            KillchainSeeder::class,
            ProtocolSeeder::class,
            Question_AnswerSeeder::class,
            CompanyProfileSeeder::class,
        ]);
    }
}
