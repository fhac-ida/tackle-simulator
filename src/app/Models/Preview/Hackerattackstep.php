<?php

namespace App\Models\Preview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hackerattackstep extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phase_id',
    ];

    //NOTE: currently not in use

    public function vulnerabilities()
    {
        return $this->belongsToMany(Vulnerability::class);
    }

    public function nextSteps()
    {
        return $this->belongsToMany(Hackerattackstep::class, 'hackerattack_step_next_step', 'current_step_id', 'next_step_id');
    }

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function scenarios()
    {
        return $this->belongsToMany(Scenario::class, 'scenariohackerstep', 'hackerattackstep_id', 'scenario_id');
    }
}
