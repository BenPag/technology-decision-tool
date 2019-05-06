<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire\Questionnaire;
use App\Repositories\Interfaces\EvaluationFromRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EvaluationFromApiController extends ModelApiController
{
    public function __construct(EvaluationFromRepositoryInterface $repository)
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

    /**
     * @param Request $request
     * @param int $questionnaireId
     * @return JsonResponse
     */
    public function storeQuestionnaireQuestions(Request $request, int $questionnaireId) : JsonResponse
    {
        /** @var Questionnaire $questionnaire */
        $questionnaire = $this->repository->find($questionnaireId);
        $questionnaire->questions()->detach();
        $questionnaire->questions()->attach(array_column($request->get('questions'), 'id'));

        return response()->json('success');
    }
}
