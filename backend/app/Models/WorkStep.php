<?php

namespace App\Models;

use App\Models\Questionnaire\Questionnaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkStep extends Model
{
    protected $fillable = [
        'position'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function questionnaire() : BelongsTo
    {
        return $this->belongsTo(EvaluationFrom::class, 'questionnaire_id');
    }
}
