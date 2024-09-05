<?php

namespace App\Models\Preview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'step'];

    public function hackerattackSteps()
    {
        return $this->hasMany(Hackerattackstep::class, 'phase_id');
    }
}
