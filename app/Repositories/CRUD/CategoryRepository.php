<?php

namespace App\Repositories\CRUD;

use App\DTO\Pagination\PaginationDTO;
use App\Models\Category;
use App\Models\User;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return Category::query();
    }

    public function getListCategories(PaginationDTO $dto): LengthAwarePaginator
    {
        return $this->getModelsQB()
            ->where('active', '=', true)
            ->orderByDesc('order')
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }

    public function getListProductsCategory(int $id, PaginationDTO $dto, ?User $user): ?LengthAwarePaginator
    {
        $category = $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();

        if (!$category)
        {
            return null;
        }

        $category->categoryProducts();

        return $category->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}
