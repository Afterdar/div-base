<?php

namespace App\Repositories\CRUD;

use App\Models\Category;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return Category::query();
    }

    public function getListActiveCategory(): Collection|array
    {
        return $this->getModelsQB()
            ->where('active', '=', true)
            ->get();
    }

    public function getCategoryById(int $id): Model|null
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();
    }
}
