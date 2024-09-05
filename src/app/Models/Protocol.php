<?php

namespace App\Models;

use App\Models\Preview\InterfaceCategory;
use App\Models\Preview\InterfaceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * This is the class to extend the Project with protocols
 * THIS IS CURRENTLY NOT USED IN THE PROGRAM!
 */

/**
 * Class Protocol
 *
 * This class represents a Protocol model that interacts with the 'protocols' table in the database.
 */
class Protocol extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the Protocol model.
     */
    protected $table = 'protocols';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'protocols' table.
     */
    protected $primaryKey = 'protocol_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Define a relationship method
     * This method establishes that each Protocol can be associated with many InterfaceModels.
     * The foreign key 'protocol_id' in the 'interface_protocol' table maps to the primary key in the 'protocols' table.
     * The foreign key 'interface_id' in the 'interface_protocol' table maps to the primary key in the 'interface_models' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interfaces(): BelongsToMany
    {
        return $this->belongsToMany(InterfaceModel::class, 'interface_protocol', 'interface_id', 'protocol_id');
    }

    /**
     * Define a relationship method
     * This method establishes that each Protocol belongs to an InterfaceCategory.
     * The foreign key 'interfacecategory_id' in the 'protocols' table maps to the primary key in the 'interfacecategories' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interfacecategories(): BelongsTo
    {
        return $this->belongsTo(InterfaceCategory::class, 'interfacecategory_id', 'interfacecategory_id');
    }
}
