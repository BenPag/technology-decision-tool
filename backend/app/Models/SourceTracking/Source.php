<?php

namespace App\Models\SourceTracking;

use App\Models\User;
use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Source extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'link', 'vote'
    ];

    /**
     * @return BelongsTo
     */
    public function subject() : BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return BelongsTo
     */
    public function sourceType() : BelongsTo
    {
        return  $this->belongsTo(SourceType::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function step() : BelongsTo
    {
        return $this->belongsTo(WorkStep::class);
    }
}
