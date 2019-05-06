<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Questionnaire extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'question_order'
    ];

    /**
     * @return mixed
     */
    public function getAttributeQuestionOrder()
    {
        return json_decode($this->attributes['question_order'], true);
    }

    /**
     * @param $value
     */
    public function setAttributeQuestionOrder($value) : void
    {
        $this->attributes['question_order'] = json_encode($value);
    }

    /**
     * @return belongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'evaluations_questions');
    }
}