<?php

namespace App\Http\Controllers\SourceTracking;

use App\Http\Controllers\ModelApiController;
use App\Repositories\Interfaces\SubjectRepositoryInterface;

class SubjectsApiController extends ModelApiController
{
    public function __construct(SubjectRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
