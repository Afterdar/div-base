<?php

namespace App\Repositories\CRUD;

use App\Models\SubCategory;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SubCategoryRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return SubCategory::query();
    }

    public function getListSubCategories(int $id): Collection|array
    {
        return $this->getModelsQB()
            ->where('category_id', '=', $id)
            ->where('active', '=', true)
            ->get();
    }

    public function getSubCategoryById(int $id): Model|null
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();
    }
}
