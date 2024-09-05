<?php

namespace App\Models\Preview;

use App\Models\Protocol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterfaceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'colorcode'];

    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class, 'interfacecategory_id', 'interfacecategory_id');
    }
}
