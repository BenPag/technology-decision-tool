<?php

namespace App\Models\SourceTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SourceType extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sources() : HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
