<?php

namespace Database\Seeders;

use App\Models\Preview\HardwareObject;
use App\Models\Preview\Killchain;
use App\Models\Preview\Scenario;
use Illuminate\Database\Seeder;

class KillchainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scenario = Scenario::first();
        $hardwareObject = HardwareObject::first();
        // Erstelle einige Killchains
        for ($i = 0; $i < 5; $i++) {
            Killchain::create([
                'scenario_id' => $scenario->scenario_id,
                'hardwareobject_id' => $hardwareObject->hardwareobject_id,
            ]);
        }
    }
}
