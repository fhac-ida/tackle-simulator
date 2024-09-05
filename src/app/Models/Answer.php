<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 *
 * This class represents an Answer model that interacts with the 'answers' table in the database.
 * represents the possible answers in the profile Page
 */
class Answer extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the Answer model.
     */
    protected $table = 'answers';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'answers' table.
     */
    protected $primaryKey = 'answer_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = [
        'answer', //normal answer
        'is_expert', //expert awnser
    ];


    /**
     * This method establishes that each Answer belongs to a Question.
     * The foreign key 'question_id' in the 'answers' table maps to the primary key 'question_id' in the 'questions' table.
     * Answer belongsTo a Question and a Question hasMany Answers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}
