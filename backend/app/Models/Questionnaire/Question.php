<?php

namespace App\Models\Questionnaire;

use App\Models\EvaluationFrom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'question',
        'type',
        'options',
        'required'
    ];

    /**
     * @return mixed
     */
    public function getOptionsAttribute()
    {
         return json_decode($this->attributes['options'], true);
    }

    /**
     * @param $value
     */
    public function setOptionsAttribute($value) : void
    {
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * @return BelongsToMany
     */
    public function evaluation() : BelongsToMany
    {
        return $this->belongsToMany(EvaluationFrom::class, 'evaluations_questions', 'question_id', 'evaluation_id');
    }

    /**
     * @return HasMany
     */
    public function answers() : HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
