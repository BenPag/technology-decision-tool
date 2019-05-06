<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class ModelApiController extends BaseController
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $baseRepository)
    {
        $this->repository = $baseRepository;
    }

    /**
     * Show all
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json($this->repository->all());
    }

    /**
     * Show model by id
     *
     * @param  $modelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($modelId) : JsonResponse
    {
        try {
            $model = $this->repository->find($modelId);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($model);
    }

    /**
     * Store all the data request in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        try {
            $model = $this->repository->create($request->all());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($model, 201);
    }

    /**
     * Update all the data request in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        try {
            $this->repository->update($request->all());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json('success');
    }

    /**
     * Delete the model in the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) : JsonResponse
    {
        try {
            $this->repository->delete($id);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json('success');
    }
}
