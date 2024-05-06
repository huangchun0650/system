<?php

namespace YFDev\System\App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /** Set Model */
    public function setModel(string $modelClass): BaseRepository;

    /** Create Or Update Multiple From Array */
    public function createOrUpdateMultipleFromArray(
        array $data,
        bool $saveMissingModelFillableAttributesToNull = true
    ): Collection;

    /** Create Or Update From Array */
    public function createOrUpdateFromArray(array $data, bool $saveMissingModelFillableAttributesToNull = true): Model;

    /** Update By Id */
    public function updateById(
        int $id,
        array $data,
        bool $saveMissingModelFillableAttributesToNull = true
    ): Model;

    /** Delete From Array */
    public function deleteFromArray(array $data): bool;

    /** Delete By Id */
    public function deleteById(int $id);

    /** Delete Multiple From Primaries */
    public function deleteMultipleFromPrimaries(array $instancePrimaries): int;

    /** Find One By Id */
    public function findOneById(int $id, $throwsExceptionIfNotFound = true);

    /** Find One From Array */
    public function findOneFromArray(array $data, $throwsExceptionIfNotFound = true);

    /** Find Multiple From Array */
    public function findMultipleFromArray(array $data): Collection;

    /** Get All */
    public function getAll($columns = ['*'], $orderBy = 'default', $orderByDirection = 'asc'): Collection;

    /** Set A Model From Array Data */
    public function make(array $data): Model;

    /** Paginate */
    public function paginate(Collection $data, $perPage = null, $sortBy = null, $orderBy = null): LengthAwarePaginator;

    /** Model Unique Instance */
    public function modelUniqueInstance(): Model;

    /** Set Missing Fillable Attributes To Null */
    public function setMissingFillableAttributesToNull(array $data): array;

    /** Find Multiple From Primaries */
    public function findMultipleFromPrimaries(array $primaries): Collection;

    /**
     * Searching Ids In Meilisearch
     *
     * This method searches for IDs in Meilisearch based on the provided parameter.

     * Note: You must first add 'use Laravel\Scout\Searchable' trait in your model.
     */
    public function searchingIds(string $param): array;

    /** Find Data Where In */
    public function findWhereIn(string $column, array $values, $orderBy = 'id', $sortBy = 'desc'): Collection;

    /** Find Data Exist */
    public function findExist(array $data);

    /** When */
    public function when($value, $callback);

    /** Call Method Function */
    public function __call($method, $parameters);

    /** Get Constants */
    public function getConstants(string $constName, ?string $fromRelation = null);
}
