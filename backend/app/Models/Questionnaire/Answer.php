<?php

namespace App\Models\Questionnaire;

use App\Models\EvaluationFrom;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'value',
        'progress'
    ];

    /**
     * @param $value
     */
    public function setProgressAttribute($value) : void
    {
        $this->attributes['progress'] = implode('_', $value);
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value) : void
    {
        $this->attributes['value'] = json_encode($value);
    }

    /**
     * @return mixed
     */
    public function getValueAttribute()
    {
        return json_decode($this->attributes['value'], true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire() : BelongsTo
    {
        return $this->belongsTo(EvaluationFrom::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
