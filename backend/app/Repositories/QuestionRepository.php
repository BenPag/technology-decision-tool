<?php

namespace App\Repositories;

use App\Models\Questionnaire\Question;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function __construct(Question $question)
    {
        parent::__construct($question);
    }
}
