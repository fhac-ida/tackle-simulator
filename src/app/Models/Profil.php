<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profil
 *
 * This class represents a Profil model that interacts with the 'company_profiles' table in the database.
 */
class Profil extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the Profil model.
     */
    protected $table = 'company_profiles';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'company_profiles' table.
     */
    protected $primaryKey = 'profile_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = [
        'user_id',
        'profile_name',
    ];

    /**
     * Define a relationship method
     * This method establishes that each Profil belongs to a User.
     * The foreign key 'user_id' in the 'company_profiles' table maps to the primary key in the 'users' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a relationship method
     * This method establishes that each Profil can belong to many Questions through a pivot table 'company_question'.
     * The foreign key 'profile_id' in the 'company_question' table maps to the primary key in the 'company_profiles' table.
     * The foreign key 'question_id' in the 'company_question' table maps to the primary key in the 'questions' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answeredQuestions()
    {
        return $this->belongsToMany(Question::class, 'company_question', 'profile_id', 'question_id')->withPivot('profile_id', 'answer_id');
    }
}
