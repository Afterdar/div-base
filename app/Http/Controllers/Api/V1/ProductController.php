<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\User\PaginateRequest;
use App\Repositories\CRUD\ProductRepository;
use App\Repositories\CRUD\UserFavouritesRepository;
use Exception;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseController
{
    private ProductRepository $productRepository;
    private UserFavouritesRepository $userFavouritesRepository;

    public function __construct(ProductRepository $productRepository, UserFavouritesRepository $userFavouritesRepository)
    {
        $this->productRepository = $productRepository;
        $this->userFavouritesRepository = $userFavouritesRepository;
    }

    public function getListProductSubCategoryById(int $id, PaginateRequest $paginateRequest): JsonResponse
    {
        $list = $this->productRepository->getListProductsSubCategoryById($id, $paginateRequest);

        return ResponseBuilder::success($list->toArray());
    }

    public function getDetailProductById(int $id): JsonResponse
    {
        $product = $this->productRepository->getProductById($id);

        if ($product === null)
        {
            throw new Exception('Товар не найден');
        }

        return ResponseBuilder::success($product->toArray());
    }

    public function addProductFavourites(int $id): JsonResponse
    {
        $user = auth()->user();

        $addFavouriteProduct = $this->userFavouritesRepository->addFavouriteProduct($id, $user);

        if ($addFavouriteProduct === false)
        {
            throw new Exception('Ошибка добавления товара в избраное');
        }

        return ResponseBuilder::success(['Товар успешно добавлен в избраное']);
    }

    public function deleteProductFavourites(int $id): JsonResponse
    {
        $user = auth()->user();

        $deleteFavouriteProduct = $this->userFavouritesRepository->deleteFavouriteProduct($id, $user);

        if ($deleteFavouriteProduct === false)
        {
            throw new Exception('Ошибка удаление товара из избраного');
        }

        return ResponseBuilder::success(['Товар успешно удален из избраного']);
    }

    public function getListFavouritesProductsUser(): JsonResponse
    {
        $user = auth()->user();

        $listFavouriteProducts = $this->userFavouritesRepository->getListFavouriteProducts($user);

        return ResponseBuilder::success($listFavouriteProducts->toArray());
    }
}
