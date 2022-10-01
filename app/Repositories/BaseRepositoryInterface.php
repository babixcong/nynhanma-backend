<?php
namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data): Builder | Model;

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool;

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): Model;

    /**
     * @param $instance
     * @param array $data
     * @return mixed
     */
    public function update($instance, array $data);

    public function findFirst(array $data);
}
