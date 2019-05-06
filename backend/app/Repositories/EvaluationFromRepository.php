<?php
namespace App\Repositories;

use App\Models\EvaluationFrom;
use App\Repositories\Interfaces\EvaluationFromRepositoryInterface;

class EvaluationFromRepository extends BaseRepository implements EvaluationFromRepositoryInterface
{
    public function __construct(EvaluationFrom $evaluationFrom)
    {
        parent::__construct($evaluationFrom);
    }
}
