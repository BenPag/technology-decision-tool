<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\ModelApiController;
use App\Models\Questionnaire\Questionnaire;
use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;
use Illuminate\Http\JsonResponse;

class QuestionnaireApiController extends ModelApiController
{
    public function __construct(QuestionnaireRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $questionnaireId
     * @return JsonResponse
     */
    public function getQuestionsByQuestionnaireId(int $questionnaireId) : JsonResponse
    {
        /** @var Questionnaire $questionnaire */
        $questionnaire = $this->repository->find($questionnaireId);
        $questions = $questionnaire->questions()->get();

        return response()->json($questions);
    }
}
