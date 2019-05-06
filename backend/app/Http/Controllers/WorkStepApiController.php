<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\WorkStepRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkStepApiController extends ModelApiController
{
    public function __construct(WorkStepRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Show all
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json($this->repository->all(['*'], 'position'));
    }

    /**
     * Update all the data request in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAll(Request $request) : JsonResponse
    {
        try {
            $this->repository->updateAll($request->get('steps'));
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json('success');
    }
}
