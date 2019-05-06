<?php

namespace App\Http\Controllers\SourceTracking;

use App\Http\Controllers\ModelApiController;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\SourcesRepositoryInterface;
use Illuminate\Http\Request;

class SourcesApiController extends ModelApiController
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request, SourcesRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->request = $request;
    }

    /**
     * Show all
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json(
            $this->repository->findBy([
                'user_id' => $this->request->user()->id
            ])
        );
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
            $attributes = $request->all();
            $attributes['user'] = $request->user();
            $model = $this->repository->create($attributes);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($model, 201);
    }
}