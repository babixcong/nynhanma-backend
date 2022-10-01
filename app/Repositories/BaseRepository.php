<?php

namespace App\Repositories;
use App\Exceptions\Common\NotFoundException;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed
     */
    abstract public function getModel(): string;

    /**
     * @return void
     */
    public function setModel(): void
    {
        $this->model = app($this->getModel());
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data): Builder | Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->model->newQuery()->insert($data);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): Model
    {
        return $this->model->newQuery()->updateOrCreate($attributes, $values);
    }

    /**
     * @param $instance
     * @param array $data
     * @return mixed
     */
    public function update($instance, array $data)
    {
        return $instance->update($data);
    }

    public function findFirst(array $data)
    {
        return $this->model->newQuery()->where($data)->first();
    }
}
