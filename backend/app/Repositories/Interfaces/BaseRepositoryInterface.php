<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

interface BaseRepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes) : bool;

    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc');

    public function find($id);

    public function findOneOrFail($id);

    public function findBy(array $data) : Collection;

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);

    public function delete($id) : bool;

    public function paginateArrayResults(array $data, int $perPage = 50) : LengthAwarePaginator;

    public function processItemTransformer(
        Model $model,
        TransformerAbstract $transformer,
        string $resourceKey,
        string $includes = null
    ) : Scope;

    public function processCollectionTransformer(
        Collection $collection,
        TransformerAbstract $transformer,
        string $resourceKey,
        string $includes = null,
        $perPage = 25
    ) : Scope;
}