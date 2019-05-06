<?php
namespace App\Repositories;

use App\Models\Questionnaire\Questionnaire;
use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;

class QuestionnaireRepository extends BaseRepository implements QuestionnaireRepositoryInterface
{
    public function __construct(Questionnaire $questionnaire)
    {
        parent::__construct($questionnaire);
    }
}
