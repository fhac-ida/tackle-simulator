<?php

namespace App\Models\Preview;

use App\Models\Protocol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterfaceModel extends Model
{
    use HasFactory;

    // Define the relationship: An Interface belongs to an Interface Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Interfacecategory::class, 'interface_category_id');
    }

    // Define the relationship: An Interface can have multiple Vulnerabilities
    public function vulnerabilities(): HasMany
    {
        return $this->hasMany(Vulnerability::class);
    }

    public function hardwareobjects(): BelongsToMany
    {
        return $this->belongsToMany(HardwareObject::class, 'hardwareobject_interface', 'hardwareobject_id', 'interface_id')->withPivot('maxConnections');
    }

    public function protocols(): BelongsToMany
    {
        return $this->belongsToMany(Protocol::class, 'interface_protocol', 'interface_id', 'protocol_id');
    }
}
