<?php

namespace App\Repositories;

use App\Models\SourceTracking\Subject;
use App\Repositories\Interfaces\SubjectRepositoryInterface;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
    }
}
