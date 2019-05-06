<?php

namespace App\Models;

use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Evaluation
 * @package App
 */
class EvaluationFrom extends Model
{
    protected $table = 'evaluations';
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
        return $this->belongsToMany(Question::class, 'evaluations_questions', 'evaluation_id', 'question_id');
    }
}
