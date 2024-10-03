<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseContract
{
    const LIMIT = 20;
    const ORDER_BY = 'id';
    const ORDER_DIR = 'desc';

    public function getModelName(): string;

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes = []): mixed;

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, array $attributes = []): mixed;

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function attach(Model $model, string $relation, array $attributes = []): mixed;

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function detach(Model $model, string $relation, array $attributes = []): mixed;

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function sync(Model $model, string $relation, array $attributes = []): mixed;

    /**
     * @param array $attributes
     * @param null $id
     *
     * @return mixed
     */
    public function createOrUpdate(array $attributes = [], $id = null): mixed;

    /**
     * @param array $attributes
     * @param array $identifier
     *
     * @return mixed
     */
    public function defaultUpdateOrCreate(array $attributes, array $identifier = []): mixed;

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public function remove(Model $model): mixed;

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function canRemove(Model $model): bool;

    /**
     * @param int $id
     * @param array $relations
     * @param array $filters
     * @return mixed
     */
    public function find(int $id, array $relations = [], array $filters = []): mixed;

    /**
     * @param int $id
     * @param array $relations
     * @param array $filters
     * @return mixed
     */
    public function findOrFail(int $id, array $relations = [], array $filters = []): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $fail
     * @return mixed
     */
    public function findBy(string $key, mixed $value, bool $fail = true): mixed;

    /**
     * @param $ids
     * @return mixed
     */
    public function findIds($ids): mixed;

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields): mixed;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param $filters
     * @return int
     */
    public function countWithFilters($filters): int;

    /**
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function withFilters($query, array $filters = []): mixed;

    /**
     * @param Model $model
     * @param $column
     * @param int $value
     * @return void
     */
    public function increment(Model $model, $column, int $value = 1): void;

    /**
     * @param Model $model
     * @param $column
     * @param $value
     * @return void
     */
    public function decrement(Model $model, $column, $value): void;

    /**
     * @param $column
     * @return mixed
     */
    public function sum($column): mixed;

    /**
     * @param $function
     * @param $column
     * @return mixed
     */
    public function aggregate($function, $column): mixed;

    /**
     * @param $query
     * @param $relations
     */
    public function applyRelations($query, $relations): mixed;

    /**
     * @param $query
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function baseSearch($query, array $filters = [],
                               array $relations = [], array $data = []): mixed;

    /**
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function search(array $filters = [], array $relations = [], array $data = []): mixed;

    /**
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function searchWithTrashed(array  $filters = [], array  $relations = [], array $data = []): mixed;

    /**
     * @param $query
     * @param array $data
     * @return mixed
     */
    public function getQueryResult($query, array $data = []): mixed;

    /**
     * @param array $attributes
     * @return array
     */
    public function cleanUpAttributes(array $attributes): array;

    /**
     * @param null $groupBy
     * @param array $fields
     * @param array $filters
     * @param array $relations
     * @param bool $applyOrder
     * @param bool $page
     * @param bool $limit
     * @param string $orderBy
     * @param string $orderDir
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function searchBySelected(
        $groupBy = null,
        array $fields = [],
        array $filters = [],
        array $relations = [],
        bool $applyOrder = false,
        bool $page = false,
        bool $limit = false,
        string $orderBy = self::ORDER_BY,
        string $orderDir = self::ORDER_DIR
    ): array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection;

    /**
     * Create a Pagination From Items Of  array Or collection.
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array|Collection $items, int $perPage = 15,
                             int $page = null, array $options = []): LengthAwarePaginator;

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function relationCreate(Model $model, string $relation, array $attributes = []): mixed;

    /**
     * @param $model
     * @param string $field
     *
     * @return mixed
     */
    public function toggleField($model, string $field): mixed;

    /**
     * @param $id
     * @return void
     */
    public function restoreDeletedRecord($id): void;

}
