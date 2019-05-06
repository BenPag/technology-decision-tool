<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\ModelApiController;
use App\Repositories\Interfaces\AnswerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerApiController extends ModelApiController
{
    public function __construct(AnswerRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Store all the data request in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMany(Request $request) : JsonResponse
    {
        try {
            $model = $this->repository->createMany($request->get('answers'));
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($model, 201);
    }
}
