<?php

namespace App\Models\Preview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Killchain extends Model
{
    use HasFactory;

    public function scenario()
    {
        return $this->belongsTo(Scenario::class, 'scenario_id'); // A Killchain belongs to a scenario
    }

    public function lastSuccessfullHackerstep()
    {
        return $this->belongsTo(Hackerattackstep::class, 'hackerattckstep_id'); // A Killchain belongs to the last successful hacker step
    }

    public function killchain_progress()
    {
        // Find the phase marked as the end phase
        $endphase = Phase::find('is_end_phase', true)->first();

        // Calculate and return the progress as a percentage
        return ($this->lastSuccessfullHackerstep()->phase()->step / $endphase->step) * 100;
    }

    public function hardwareobject()
    {
        return $this->belongsTo(HardwareObject::class, 'hardwareobject_id'); //A Killchain belongs to a HardwareObject
    }
}
