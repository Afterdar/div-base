<?php

namespace App\Repositories\CRUD\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CRUDRepositoryInterface
{
    public function getModelsQB(): Builder;

    public function getAll(): Collection;

    public function getModelById(int $id): ?Model;
}
