<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OperatingSystem
 *
 * This class represents an OperatingSystem model that interacts with the 'operatingsystems' table in the database.
 * Represents the different operating Systems the individual devices can have
 */
class OperatingSystem extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the OperatingSystem model.
     */
    protected $table = 'operatingsystems';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'operatingsystems' table.
     */
    protected $primaryKey = 'operatingsystem_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = ['name'];

    /**
     * Define a relationship method
     * This method establishes that each OperatingSystem has many OperatingSystemVersions.
     * The foreign key 'operatingsystem_id' in the 'operatingsystem_versions' table maps to the primary key 'operatingsystem_id' in the 'operatingsystems' table.
     * Devices have operating systems with different versions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OperatingSystemVersion::class, 'operatingsystem_version_id');
    }
}
