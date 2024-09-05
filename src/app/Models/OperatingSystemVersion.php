<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OperatingSystemVersion
 *
 * This class represents an OperatingSystemVersion model that interacts with the 'operatingsystem_versions' table in the database.
 * Represents the version of an OperatingSystemVersion of the devices
 */
class OperatingSystemVersion extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the OperatingSystemVersion model.
     */
    protected $table = 'operatingsystem_versions';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'operatingsystem_versions' table.
     */
    protected $primaryKey = 'operatingsystem_version_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = ['version', 'release_date', 'end_of_service', 'operatingsystem_id'];

    /**
     * Define a relationship method
     * This method establishes that each OperatingSystemVersion belongs to an OperatingSystem.
     * The foreign key 'operatingsystem_id' in the 'operatingsystem_versions' table maps to the primary key in the 'operatingsystems' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operatingSystem(): BelongsTo
    {
        return $this->belongsTo(OperatingSystem::class, 'operatingsystem_id');
    }

    /**
     * Define a relationship method
     * This method establishes that each OperatingSystemVersion can have many HardwareObjects.
     * The foreign key 'operatingsystem_version_id' in the 'hardwareobjects' table maps to the primary key in the 'operatingsystem_versions' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hardwareObjects(): HasMany
    {
        return $this->hasMany(HardwareObject::class, 'hardwareobject_id');
    }
}
