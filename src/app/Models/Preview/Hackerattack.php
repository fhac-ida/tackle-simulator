<?php

namespace App\Models\Preview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hackerattack extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Define the relationship: A Hackerattack consists of multiple HackerattackSteps
    public function hackerattackSteps()
    {
        return $this->hasMany(Hackerattackstep::class);
    }
}
