<?php

namespace App\Models\Preview;

use App\Services\ScenarioService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $appends = ['paths'];

    public function hackerattackSteps()
    {
        return $this->belongsToMany(Hackerattackstep::class, 'scenariohackerstep', 'scenario_id', 'hackerattackstep_id');
    }

    // Definition des Accessors für 'paths'
    public function getPathsAttribute()
    {
        $service = new ScenarioService(); // Instanzieren Sie Ihren ScenarioService

        return $service->getAllPaths($this);
    }
}
