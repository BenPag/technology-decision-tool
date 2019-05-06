<?php

namespace App\Repositories;

use App\Models\SourceTracking\Source;
use App\Repositories\Interfaces\SourcesRepositoryInterface;

class SourcesRepository extends BaseRepository implements SourcesRepositoryInterface
{
    public function __construct(Source $source)
    {
        parent::__construct($source);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        /** @var Source $model */
        $model = new Source($attributes);
        $model->user()->associate($attributes['user']);
        $model->subject()->associate($attributes['subject']);
        $model->sourceType()->associate($attributes['sourceType']);
        $model->step()->associate($attributes['stepId']);
        $model->save();

        return $model;
    }
}
