<?php

namespace App\Repositories;

use App\Models\SourceTracking\SourceType;
use App\Repositories\Interfaces\SourceTypeRepositoryInterface;

class SourceTypeRepository extends BaseRepository implements SourceTypeRepositoryInterface
{
    public function __construct(SourceType $sourceType)
    {
        parent::__construct($sourceType);
    }
}
