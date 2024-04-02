<?php

namespace App\Repositories\CRUD;

use App\Http\Requests\User\PaginateRequest;
use App\Models\Product;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return Product::query();
    }

    public function getListProductsSubCategoryById(int $id, PaginateRequest $paginateRequest): LengthAwarePaginator
    {
        return $this->getModelsQB()
            ->where('sub_category_id', '=', $id)
            ->where('active', '=', true)
            ->paginate($paginateRequest['perPage']);
    }

    public function getProductById(int $id): Model|null
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();
    }
}
