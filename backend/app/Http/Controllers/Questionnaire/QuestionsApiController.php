<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\ModelApiController;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionsApiController extends ModelApiController
{
    public function __construct(QuestionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
