<?php

namespace App\Http\Controllers\SourceTracking;

use App\Http\Controllers\ModelApiController;
use App\Repositories\Interfaces\SourceTypeRepositoryInterface;

class SourceTypesApiController extends ModelApiController
{
    public function __construct(SourceTypeRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}