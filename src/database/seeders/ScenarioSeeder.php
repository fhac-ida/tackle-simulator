<?php

namespace Database\Seeders;

use App\Models\Preview\Hackerattackstep;
use App\Models\Preview\Scenario;
use Illuminate\Database\Seeder;

class ScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scenarios = [
            Scenario::create(['name' => 'Scenario 1']),
            Scenario::create(['name' => 'Scenario 2']),
            Scenario::create(['name' => 'Scenario 3']),
        ];

        foreach ($scenarios as $scenario) {
            // Jede Phase-ID von 1 bis 8
            for ($phaseId = 1; $phaseId <= 8; $phaseId++) {
                // Holen Sie 1 bis 2 zufällige HackerattackSteps für jede Phase
                $stepsForPhase = Hackerattackstep::where('phase_id', $phaseId)
                    ->inRandomOrder()
                    ->take(rand(1, 2)) // 1 oder 2 Schritte pro Phase
                    ->get();

                // Fügen Sie die Schritte zum aktuellen Szenario hinzu
                $scenario->hackerattackSteps()->attach($stepsForPhase);
            }
        }
    }
}
