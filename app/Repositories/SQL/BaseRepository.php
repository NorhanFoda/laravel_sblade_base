<?php

namespace App\Repositories\SQL;

use App\Exceptions\CantDeleteModelException;
use App\Repositories\Contracts\BaseContract;
use App\Traits\ActivityLogTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseContract
{
    use ActivityLogTrait;

    protected Model $model;
    protected string $modelName;
    protected Builder $query;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->modelName = class_basename($this->model);
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            if (method_exists($this, 'beforeCreate')) {
                $attributes = $this->beforeCreate($attributes);
            }
            $filtered = $this->cleanUpAttributes($attributes);
            $model = $this->model->create($filtered);
            if (method_exists($this, 'syncRelations')) {
                $this->syncRelations($model, $attributes);
            }
            $this->propertyLogActivity(
                $model,
                auth()->user(),
                "$this->modelName #id: $model->id Created",
                ['action' => 'Creation',
                    'data' => [
                        'user' => auth()->user()?->name,
                        'url' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]]
            );
            if (method_exists($this, 'afterCreate')) {
                $this->afterCreate($model, $attributes);
            }
            return $model->refresh();
        }
        return false;
    }

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            $oldModel = $model->replicate();
            if (method_exists($this, 'beforeUpdate')) {
                $attributes = $this->beforeUpdate($attributes);
            }
            // Clean the attributes from unnecessary inputs
            $filtered = $this->cleanUpAttributes($attributes);
            $model = tap($model)->update($filtered)->fresh();
            $changes = $this->customLogOnUpdateFields($filtered, $oldModel, $model);
            if (method_exists($this, 'syncRelations')) {
                $this->syncRelations($model, $attributes);
            }
            if (method_exists($this, 'afterUpdate')) {
                $this->afterUpdate($model, $changes);
            }
            return $model;
        }
        return false;
    }

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function attach(Model $model, string $relation, array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            return $model->{$relation}()->attach($attributes);
        }
        return false;
    }

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function detach(Model $model, string $relation, array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            return $model->{$relation}()->detach($attributes);
        }
        return false;
    }

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function sync(Model $model, string $relation, array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            return $model->{$relation}()->sync($attributes);
        }
        return false;
    }

    /**
     * @param array $attributes
     * @param null $id
     *
     * @return bool|mixed
     */
    public function createOrUpdate(array $attributes = [], $id = null): mixed
    {
        if (empty($attributes)) {
            return false;
        }
        $filtered = $this->cleanUpAttributes($attributes);
        if ($id) {
            $model = $this->model->find($id);
            return $this->update($model, $filtered);
        }
        return $this->create($filtered);
    }

    /**
     * @param array $attributes
     * @param array $identifier
     *
     * @return bool|mixed
     */
    public function defaultUpdateOrCreate(array $attributes, array $identifier = []): mixed
    {
        if (empty($attributes)) {
            return false;
        }
        // Clean the attributes from unnecessary inputs
        $attributes = $this->cleanUpAttributes($attributes);
        $identifier = $this->cleanUpAttributes($identifier);
        return $this->model->updateOrCreate($attributes, $identifier);
    }

    /**
     * @param Model $model
     * @return bool|mixed|null
     * @throws Exception
     */
    public function remove(Model $model): mixed
    {
        // Check if it has relations
        foreach ($model->getDefinedRelations() as $relation) {
            if ($model->$relation()->count()) {
                throw new CantDeleteModelException(__("messages.errors.cannot_delete", ['model' => $this->modelName, 'relation' => $relation]));
            }
        }
        $this->propertyLogActivity(
            $model,
            auth()->user(),
            "$this->modelName #id: $model->id Removed",
            ['action' => 'Removing',
                'data' => [
                    'user' => auth()->user()?->name,
                    'url' => '',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]]
        );
        return $model->delete();
    }

    public function canRemove(Model $model): bool
    {
        // Check if model has relations
        foreach ($model->getDefinedRelations() as $relation) {
            if ($model->$relation()->count()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param int|array $id
     * @param array $relations
     * @param array $filters
     * @return mixed
     */
    public function find(int|array $id, array $relations = [], array $filters = []): mixed
    {
        $query = $this->applyRelations($this->model, $relations);
        return $this->withFilters($query, $filters)->find($id);
    }

    /**
     * @param int $id
     * @param array $relations
     * @param array $filters
     * @return mixed
     */
    public function findOrFail(int $id, array $relations = [], array $filters = []): mixed
    {
        $query = $this->applyRelations($this->model, $relations);
        return $this->withFilters($query, $filters)->findOrFail($id);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $fail
     * @return mixed
     */
    public function findBy(string $key, mixed $value, bool $fail = true): mixed
    {
        $model = $this->model->where($key, $value);
        return $fail ? $model->firstOrFail() : $model->first();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function findIds($ids): mixed
    {
        return $this->model->findOrFail($ids);
    }

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields): mixed
    {
        $query = $this->model;
        if (isset($fields['and'])) {
            $query = $query->where($fields['and']);
        }
        if (isset($fields['or'])) {
            $query = $query->orWhere(function (Builder $query) use ($fields) {
                foreach ($fields['or'] as $condition) {
                    $query = $query->orWhere($condition[0], $condition[1]);
                }
            });
        }
        return $query->first();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * @param $filters
     * @return int
     */
    public function countWithFilters($filters): int
    {
        $query = $this->withFilters($this->model, $filters);
        return $query->count();
    }

    /**
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function withFilters($query, array $filters = []): mixed
    {
        if (count($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (!empty($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }
        return $query;
    }

    /**
     * @param Model $model
     * @param $column
     * @param int $value
     * @return void
     */
    public function increment(Model $model, $column, int $value = 1): void
    {
        $model->increment($column, $value);
    }

    /**
     * @param Model $model
     * @param $column
     * @param $value
     * @return void
     */
    public function decrement(Model $model, $column, $value): void
    {
        $model->decrement($column, $value);
    }

    /**
     * @param $column
     * @return mixed
     */
    public function sum($column): mixed
    {
        return $this->aggregate('sum', $column);
    }

    /**
     * @param $function
     * @param $column
     * @return mixed
     */
    public function aggregate($function, $column): mixed
    {
        return $this->model->{$function}($column);
    }

    /**
     * @param $query
     * @param $relations
     * @return mixed
     */
    public function applyRelations($query, $relations): mixed
    {
        if (!empty($relations)) {
            $query = $query->with($relations);
        }
        return $query;
    }

    /**
     * @param $query
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function baseSearch($query, array $filters = [],
                               array $relations = [], array $data = []): mixed
    {
        $query = $this->applyRelations($query, $relations);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                //if (isset($filters[$filter]) and !empty($filters[$filter])) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }
        return $query;
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function search(array $filters = [], array $relations = [], array $data = []): mixed
    {
        $query = $this->baseSearch($this->model, $filters, $relations, $data);
        return $this->getQueryResult($query, $data);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param array $data
     * @return mixed
     */
    public function searchWithTrashed(array  $filters = [], array  $relations = [], array $data = []): mixed
    {
        $query = $this->baseSearch($this->model->withTrashed(), $filters, $relations, $data);
        return $this->getQueryResult($query, $data);
    }

    /**
     * @param $query
     * @param array $data
     * @return mixed
     */
    public function getQueryResult($query, array $data = []): mixed
    {
        $page = $data['page'] ?? true;
        $limit = $data['limit'] ?? self::LIMIT;
        $customizePaginationURI = $data['customizePaginationUri'] ?? null;
        $paginationURI = $data['paginationUri'] ?? null;
        $order = $data['order'] ?? [];
        /**
         * orderIgnoreNull
         *
         * $orderIgnoreNull: to order items with specific and keep null values in the last
         * $orderIgnoreNull['nullable_column']: when the column specified here is null, the item will be sorted in the last
         * $orderIgnoreNull['order_column']: order by column
         * $orderIgnoreNull['dir']: order direction
         *
         * example:
         *
         * $orderIgnoreNull = [
         *  'nullable_column' => 'parent_id',
         *  'order_column' => 'id',
         *  'dir' => 'DESC'
         * ]
         */
        $orderIgnoreNull = $data['orderIgnoreNull'] ?? [];
        if (!empty($orderIgnoreNull)) {
            $query = $query->orderByRaw("CASE WHEN ".$orderIgnoreNull['nullable_column']." IS NULL THEN 1 ELSE 0 END")
                ->orderBy($orderIgnoreNull['order_column'], $orderIgnoreNull['dir']);
        }
        if (!empty($order)) {
            foreach ($order as $orderBy => $orderDir) {
                $query = $query->orderBy($orderBy, $orderDir);
            }
        }else{
            $query = $query->latest();
        }
        if (config('app.query_debug')) {
            info($query->toSql());
        }
        $groupBy = $data['groupBy'] ?? null;
        if (!empty($groupBy)) {
            return $query->get()->groupBy($groupBy);
        }
        if ($customizePaginationURI) {
            $query = $query->paginate($limit);
            return $query->withPath($paginationURI);
        }
        if ($page) {
            return $query->paginate($limit);
        }
        if ($limit) {
            return $query->take($limit)->get();
        }
        return $query->get();
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function cleanUpAttributes(array $attributes): array
    {
        return collect($attributes)->filter(function ($value, $key) {
            return $this->model->isFillable($key);
        })->toArray();
    }

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
    ): array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        $query = $this->model;
        $query = $this->applyRelations($query, $relations);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                //if (isset($filters[$filter]) and !empty($filters[$filter])) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }
        if (!empty($fields)) {
            $query = $query->selectRaw(implode(',', $fields));
        }
        if (!empty($groupBy)) {
            $query = $query->groupBy(implode(',', $groupBy));
        }
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }
        if ($page) {
            return $query->paginate($limit);
        }
        if ($limit) {
            return $query->take($limit)->get();
        }
        return $query->get();
    }

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
    public function paginate(array|Collection $items, int $perPage = 15, int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @param Model $model
     * @param string $relation
     * @param array $attributes
     *
     * @return mixed
     */
    public function relationCreate(Model $model, string $relation, array $attributes = []): mixed
    {
        if (!empty($attributes)) {
            return $model->{$relation}()->create($attributes);
        }
        return false;
    }


    /**
     * @param $model
     * @param string $field
     *
     * @return mixed
     */
    public function toggleField($model, string $field): mixed
    {
        $newVal = 1;
        if ($model[$field] === 1) {$newVal = 0;}
        return $this->update($model, [$field => $newVal]);
    }

    /**
     * @param $id
     * @return void
     */
    public function restoreDeletedRecord($id): void
    {
        $this->model->withTrashed()->find($id)->restore();
    }
}
