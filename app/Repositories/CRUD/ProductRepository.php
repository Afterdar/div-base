<?php

namespace App\Repositories\CRUD;

use App\DTO\Pagination\PaginationDTO;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Contracts\Auth\Authenticatable;
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

    public function getProductById(int $id): Model|null
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->where('active', '=', true)
            ->first();
    }

    public function getListProductsCategory(int $id, PaginationDTO $dto): LengthAwarePaginator
    {
        return $this->getModelsQB()
            ->join('category_products', 'products.id' , '=', 'category_products.product_id')
            ->where('category_products.category_id', '=', $id)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }

    public function addProductFavoriteList(int $id, User $user): \Exception|bool
    {
        $product = $this->getModelsQB()
            ->where('id', '=', $id)
            ->where('active', '=', true)
            ->first();

        if (!$product)
        {
            throw new \Exception('Товар не найден');
        }

        $checkUniqueProductList = $this->getModelsQB()
            ->join('favorite_products', 'product_id', '=', 'favorite_products.product_id')
            ->where('user_id', '=', $user['id'])
            ->where('product_id', '=', $product['id'])
            ->first();

        if ($checkUniqueProductList)
        {
            throw new \Exception('Товар уже добавлен в избраное');
        }

        $user->favoritesProducts()->attach($product->id);

        return true;
    }

    public function deleteProductFavoriteList(int $id, User $user): \Exception|bool
    {
        $productFavorite = $this->getModelsQB()
            ->join('favorite_products', 'product_id', '=', 'favorite_products.product_id')
            ->where('user_id', '=', $user['id'])
            ->where('product_id', '=', $id)
            ->first();

        if ($productFavorite === null)
        {
            throw new \Exception('Товар не найден');
        }

        $user->favoritesProducts()->detach($id);

        return true;
    }

    public function listFavoriteProducts(User $user, PaginationDTO $dto): LengthAwarePaginator
    {
        return $user->favoritesProducts()->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}
