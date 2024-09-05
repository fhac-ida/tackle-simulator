<?php

namespace App\Models\Preview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HardwareObject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'vendor', 'einfuehrungsjahr', 'hasFirewall', 'hasEncryption', 'hasUserManagement', 'hasBackup', 'hasPassword', 'hasMemoryPassword'];

    // Define the relationship: A HardwareObject has many Interfaces
    public function interfaces(): BelongsToMany
    {
        return $this->belongsToMany(InterfaceModel::class)->withPivot('maxConnections');
    }

    public function operatingsystem_version(): BelongsTo
    {
        return $this->belongsTo(OperatingSystemVersion::class, 'operatingsystem_version_id');
    }
}
