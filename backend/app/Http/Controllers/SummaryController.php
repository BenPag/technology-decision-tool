<?php

namespace App\Http\Controllers;

use App\Models\EvaluationFrom;
use App\Models\Questionnaire\Answer;
use App\Models\Questionnaire\Question;
use App\Repositories\Interfaces\EvaluationFromRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class SummaryController extends BaseController
{
    private $evaluationRepository;

    public function __construct(EvaluationFromRepositoryInterface $evaluationRepository)
    {
        $this->evaluationRepository = $evaluationRepository;
    }

    public function index() : JsonResponse
    {
        if (!auth()->user()->isAdmin) {
            return response()->json('Permission denied', 403);
        }

        return response()->json($this->getResultsOfAllQuestionnaires());
    }

    /**
     * @return array
     */
    public function getResultsOfAllQuestionnaires() : array
    {
        $result = [];
        /** @var EvaluationFrom $evaluationFrom */
        foreach ($this->evaluationRepository->all() as $evaluationFrom) {
            $result[] = [
                'name' => $evaluationFrom->getAttribute('name'),
                'questions' => $this->getQuestionsWithAnswersOfQuestionnaire($evaluationFrom)
            ];
        }
        return $result;
    }

    /**
     * @param EvaluationFrom $evaluationFrom
     * @return array
     */
    private function getQuestionsWithAnswersOfQuestionnaire(EvaluationFrom $evaluationFrom) : array
    {
        $result = [];
        /** @var Question $question */
        foreach ($evaluationFrom->questions()->get() as $question) {
            $result[] = [
                'question' => $question->getAttribute('question'),
                'answers' => $this->formatAnswers($question, $evaluationFrom->getAttribute('id'))
            ];
        }
        return $result;
    }

    /**
     * @param Question $question
     * @param int $evaluationFromId
     * @return array
     */
    private function formatAnswers(Question $question, int $evaluationFromId) : array
    {
        $result = [];
        $answers = $question->answers()->where('questionnaire_id', $evaluationFromId)->get();
        $maxCount = \count($answers);

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            if (isset($result[$answer->getAttribute('value')])) {
                $result[$answer->getAttribute('value')]['count']++;
            } else {
                $result[$answer->getAttribute('value')]['count'] = 1;
                $result[$answer->getAttribute('value')]['maxCount'] = $maxCount;
            }
        }


        return $result;
    }
}
