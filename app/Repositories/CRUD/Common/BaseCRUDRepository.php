<?php

namespace App\Repositories\CRUD\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseCRUDRepository implements CRUDRepositoryInterface
{
    abstract public function getModelsQB(): Builder;

    public function getModelById(int $id): ?Model
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();
    }

    public function getAll(): Collection
    {
        return $this->getModelsQB()->get();
    }
}
