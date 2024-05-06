<?php

namespace YFDev\System\App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use YFDev\System\App\Constants\Paginate;

abstract class BaseRepository implements BaseRepositoryInterface
{
    // use QueryTrait;

    protected $model;

    protected $paginate;

    protected $limit;

    protected $defaultAttributesToExcept = ['_token', '_method'];

    protected $exceptDefaultAttributes = true;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        if ($this->model) {
            $this->setModel($this->model);
        }

        $this->paginate = Paginate::DEFAULT_PER_PAGE;
        $this->limit = Paginate::TAKE_LIMIT;
    }

    /**
     * Conditionally apply a callback to the query.
     *
     * @param  mixed  $value
     * @param  Closure|callable  $callback
     * @return $this
     */
    public function when($value, $callback)
    {
        if ($value) {
            $this->model = $callback($this->model->newQuery(), $value);
        }

        return $this;
    }

    /**
     * Dynamically forward calls to the model instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->model->{$method}(...$parameters);
    }

    public function createOrUpdateMultipleFromArray(
        array $data,
        bool $saveMissingModelFillableAttributesToNull = true
    ): Collection {
        $models = new Collection();
        foreach ($data as $instanceData) {
            $models->push($this->createOrUpdateFromArray($instanceData, $saveMissingModelFillableAttributesToNull));
        }

        return $models;
    }

    /**
     * Create Or Update From Array
     */
    public function createOrUpdateFromArray(array $data, bool $saveMissingModelFillableAttributesToNull = true): Model
    {
        $id = $this->getModelIdFromArray($data);

        return $id
            ? $this->updateById($id, $data, $saveMissingModelFillableAttributesToNull)
            : $this->getModel()->create($data);
    }

    /**
     * Get ModelId From Array
     *
     * @return void
     */
    protected function getModelIdFromArray(array $data)
    {
        return Arr::get($data, $this->getModel()->getKeyName());
    }

    /**
     * Get Model
     */
    protected function getModel(): Model
    {
        if ($this->model instanceof Model) {
            return $this->model;
        }
        throw new ModelNotFoundException(
            'You must declare your repository $model attribute with an Illuminate\Database\Eloquent\Model '
            .'namespace to use this feature.'
        );
    }

    /**
     * Set Model
     */
    public function setModel(string $modelClass): BaseRepository
    {
        $this->model = app($modelClass);

        return $this;
    }

    /**
     * Update Data By Id
     */
    public function updateById(
        int $id,
        array $data,
        bool $saveMissingModelFillableAttributesToNull = true
    ): Model {
        $instance = $this->getModel()->findOrFail($id);
        $data = $saveMissingModelFillableAttributesToNull ? $this->setMissingFillableAttributesToNull($data) : $data;
        $instance->update($data);

        return $instance;
    }

    /**
     * Set Missing Fillable Attributes To Null
     */
    public function setMissingFillableAttributesToNull(array $data): array
    {
        $fillableAttributes = $this->getModel()->getFillable();
        $dataWithMissingAttributesToNull = [];
        foreach ($fillableAttributes as $fillableAttribute) {
            $dataWithMissingAttributesToNull[$fillableAttribute] = isset($data[$fillableAttribute]) ? $data[$fillableAttribute] : null;
        }

        return $dataWithMissingAttributesToNull;
    }

    /**
     * Delete Data From Array
     */
    public function deleteFromArray(array $data): bool
    {
        $id = $this->getModelIdFromArray($data);

        return $this->getModel()->findOrFail($id)->delete();
    }

    /**
     * Delete Data By Id
     *
     * @return void
     */
    public function deleteById(int $id)
    {
        return $this->getModel()->findOrFail($id)->delete();
    }

    /**
     * Delete Multiple Data From Primaries
     */
    public function deleteMultipleFromPrimaries(array $instancePrimaries): int
    {
        return $this->getModel()->destroy($instancePrimaries);
    }

    /**
     * Find One By Id
     *
     * @param  bool  $throwsExceptionIfNotFound
     * @return void
     */
    public function findOneById(int $id, $throwsExceptionIfNotFound = true)
    {
        return $throwsExceptionIfNotFound
            ? $this->getModel()->findOrFail($id)
            : $this->getModel()->find($id);
    }

    /**
     * Find One From Array
     *
     * @param  bool  $throwsExceptionIfNotFound
     * @return void
     */
    public function findOneFromArray(array $data, $throwsExceptionIfNotFound = true)
    {
        return $throwsExceptionIfNotFound
            ? $this->getModel()->where($data)->firstOrFail()
            : $this->getModel()->where($data)->first();
    }

    /**
     * Find Multiple Data From Array
     */
    public function findMultipleFromArray(array $data): Collection
    {
        return $this->getModel()->where($data)->get();
    }

    /**
     * Get All Data
     *
     * @param  array  $columns
     * @param  string  $orderBy
     * @param  string  $orderByDirection
     */
    public function getAll($columns = ['*'], $orderBy = 'default', $orderByDirection = 'asc'): Collection
    {
        $orderBy = $orderBy === 'default' || $orderBy === null ? $this->getModel()->getKeyName() : $orderBy;
        $orderByDirection = $orderByDirection ?? 'desc';

        return $this->getModel()->orderBy($orderBy, $orderByDirection)->get($columns);
    }

    /**
     * Use Array to Make A Model
     */
    public function make(array $data): Model
    {
        return app($this->getModel()->getMorphClass())->fill($data);
    }

    /**
     * paginate
     * 將 Collection 包裝成分頁的 Eloquent 模型
     *
     * @param [type] $perPage
     * @param [type] $sortBy
     * @param [type] $orderBy
     */
    public function paginate(Collection $data, $perPage = null, $sortBy = null, $orderBy = null): LengthAwarePaginator
    {
        $perPage = (int) $perPage ?: $this->paginate;

        $sortBy = $sortBy ?? $this->getModel()->getKeyName();
        $orderBy = $orderBy ?? 'asc';

        $sorted = $data->sortBy->{$sortBy};

        if ($orderBy === 'desc') {
            $sorted = $sorted->reverse();
        }

        // 獲取當前頁
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // 分割集合到分頁
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($currentItems, $data->count(), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);
    }

    public function modelUniqueInstance(): Model
    {
        $modelInstance = $this->getModel()->first();
        if (! $modelInstance) {
            $modelInstance = $this->getModel()->create([]);
        }

        return $modelInstance;
    }

    /**
     * Find Multiple From Primaries
     */
    public function findMultipleFromPrimaries(array $primaries): Collection
    {
        return $this->getModel()->findMany($primaries);
    }

    /**
     * Searching Ids
     * MeiliSearch Search The Key Word And Return Ids
     */
    public function searchingIds(string $param): array
    {
        $data = $this->getModel()->search($param)->get();

        return $data->pluck('id')->all();
    }

    /**
     * Find Where In
     *
     * @param  string  $orderBy
     * @param  string  $sortBy
     */
    public function findWhereIn(string $column, array $values, $orderBy = 'id', $sortBy = 'desc'): Collection
    {
        return $this->getModel()->whereIn($column, $values)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * Find Data Exists
     *
     * @return void
     */
    public function findExist(array $data)
    {
        $data = $this->getModel()->where($data)->get();

        return $data->isEmpty() ? false : $data;
    }

    /**
     * Get Constants
     * Find Constants In App\Constants
     *
     * @param [type] $fromRelation
     * @return void
     */
    public function getConstants(string $constName, ?string $fromRelation = null)
    {
        $model = $this->model;

        if ($fromRelation) {
            $model = $model->$fromRelation()->getRelated();
        }

        if (defined(get_class($model).'::'.$constName)) {
            return constant(get_class($model).'::'.$constName);
        }

        throw new \Exception("Constant {$constName} is not defined in ".get_class($model));
    }

    /**
     * addAssociationToModel
     * 一對一寫入關聯
     *
     * @param  Request  $request
     * @param  array  $fields
     * @return void
     */
    public function addAssociationToModel(Model $model, string $association, array $params)
    {
        if (! method_exists($model, $association)) {
            throw new \Exception("The association {$association} does not exist on the model.");
        }

        // 轉換要寫入的參數
        return $model->$association()->create($params);
    }
}
