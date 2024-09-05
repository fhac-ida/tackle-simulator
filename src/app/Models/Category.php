<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * This class represents a Category model that interacts with the 'categories' table in the database.
 * represents the possible categorys in the profile Page
 */
class Category extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the Category model.
     */
    protected $table = 'categories';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'categories' table.
     */
    protected $primaryKey = 'category_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = [
        'name', //category name
    ];

    /**
     * Define a relationship method
     *
     * This method establishes that each Category can have many Questions.
     * The foreign key 'category_id' in the 'questions' table maps to the primary key 'category_id' in the 'categories' table.
     *  Category hasMany Questions and a Question belongsTo a Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id', 'category_id');
    }
}
