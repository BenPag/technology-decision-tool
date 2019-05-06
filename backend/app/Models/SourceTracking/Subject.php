<?php

namespace App\Models\SourceTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'name'
    ];

    public function sources() : HasMany
    {
        return $this->hasMany(Source::class);
    }
}
