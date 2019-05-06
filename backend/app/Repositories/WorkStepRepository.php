<?php

namespace App\Repositories;

use App\Models\WorkStep;
use App\Repositories\Interfaces\WorkStepRepositoryInterface;

class WorkStepRepository extends BaseRepository implements WorkStepRepositoryInterface
{
    public function __construct(WorkStep $workStep)
    {
        parent::__construct($workStep);
    }

    public function updateAll($attributes): bool
    {
        $return = true;
        foreach ($attributes as $attribute) {
            if (!$this->update($attribute)) {
                $return = false;
            }
        }

        return $return;
    }
}
