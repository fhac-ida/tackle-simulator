<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 *
 * This class represents a Question model that interacts with the 'questions' table in the database.
 */
class Question extends Model
{
    use HasFactory; //enables factory-based creation of model instances

    /**
     * @var string $table
     * This property specifies the table associated with the Question model.
     */
    protected $table = 'questions';

    /**
     * @var string $primaryKey
     * This property specifies the primary key of the 'questions' table.
     */
    protected $primaryKey = 'question_id';

    /**
     * @var array $fillable
     * This property defines the attributes that are assignable
     */
    protected $fillable = [
        'question',
    ];

    /**
     * Define a many-to-many relationship method
     * This method establishes that each Question can be answered by many Companies and each Company can answer many Questions.
     * The pivot table 'company_question' stores the relationship between questions and companies.
     * The pivot table also includes an 'answer_id' which represents the answer provided by the company to the question.
     * A question is answered by many companies and a company answers many questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companyQuestionanswer()
    {
        return $this->belongsToMany(Profil::class, 'company_question')->withPivot('answer_id');
    }

    /**
     * Define a one-to-many relationship method
     *
     * This method establishes that each Question can have many Answers.
     * The foreign key 'question_id' in the 'answers' table maps to the primary key in the 'questions' table.
     * Question hasMany Answers and an Answer belongsTo a Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'question_id');
    }

    /**
     * Define a belongs-to relationship method
     *
     * This method establishes that each Question belongs to a Category.
     * The foreign key 'category_id' in the 'questions' table maps to the primary key in the 'categories' table.
     * Question belongsTo a Category and a Category hasMany Questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
