<?php

namespace App\Repositories\CRUD;

use App\Models\UserFavourite;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserFavouritesRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return UserFavourite::query();
    }

    public function addFavouriteProduct(int $id, ?Authenticatable $user): bool
    {
        $favouriteProduct = $this->getModelsQB()
            ->where('user_id', '=', $user['id'])
            ->where('product_id', '=', $id)
            ->first();

        if ($favouriteProduct !== null)
        {
            return false;
        }

        return $this->getModelsQB()
            ->insert(
                [
                    'user_id' => $user['id'],
                    'product_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
    }

    public function deleteFavouriteProduct(int $id, ?Authenticatable $user): bool
    {
        $favouriteProduct = $this->getModelsQB()
            ->where('user_id', '=', $user['id'])
            ->where('product_id', '=', $id)
            ->first();

        if ($favouriteProduct === null)
        {
            return false;
        }

        return $favouriteProduct->delete();
    }

    public function getListFavouriteProducts(?Authenticatable $user): Collection|array
    {
        return $this->getModelsQB()
            ->where('user_id', '=', $user['id'])
            ->join('products', 'product_id', '=', 'products.id')
            ->select('products.id', 'products.title', 'products.image', 'products.price')
            ->get();
    }
}
