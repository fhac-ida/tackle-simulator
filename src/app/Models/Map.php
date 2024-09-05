<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Map
 *
 * This class represents a Map model that interacts with the 'maps' table in the database.
 * represents the possible Maps available in the map selection page
 */
class Map extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable.
     */
    protected $fillable = [
        'name',
        'enumVar',
        'stringVar',
        'boolVar',
        'timestampVar',
        'user_id',
        'floatVar',
    ];

    /**
     * Define a relationship method
     * This method establishes that each Map belongs to a User.
     * The foreign key 'user_id' in the 'maps' table maps to the primary key 'id' in the 'users' table.
     * Map belongs to a user and there can be multiple maps
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
