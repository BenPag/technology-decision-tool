<?php

namespace App\Repositories\Interfaces;

interface WorkStepRepositoryInterface extends BaseRepositoryInterface
{
    public function updateAll($attributes) : bool;
}
