<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksApiController extends ModelApiController
{
    public function __construct(TaskRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function update(Request $request) : JsonResponse
    {
        try {
            $this->repository->update($request->all());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($request->all());
    }
}
