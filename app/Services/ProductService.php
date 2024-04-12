<?php

namespace App\Services;

use App\DTO\Pagination\PaginationDTO;
use App\Models\User;
use App\Repositories\CRUD\ProductRepository;
use App\Services\Common\ServiceResult;
use Illuminate\Http\JsonResponse;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductById(int $id): ServiceResult
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product)
        {
            return ServiceResult::createErrorResult('Не найден товар', status: 404);
        }

        return ServiceResult::createSuccessResult($product);
    }

    public function getListProductsCategory(int $id, PaginationDTO $dto): ServiceResult
    {
        $listProducts = $this->productRepository->getListProductsCategory($id, $dto);

        return ServiceResult::createSuccessResult($listProducts);
    }

    /**
     * @throws \Exception
     */
    public function addProductFavoriteList(int $id, User $user): ServiceResult
    {
        $addProductFavoriteList = $this->productRepository->addProductFavoriteList($id, $user);

        return ServiceResult::createSuccessResult($addProductFavoriteList);
    }

    public function deleteProductFavoriteList(int $id, User $user): ServiceResult
    {
        $deleteProductFavoriteList = $this->productRepository->deleteProductFavoriteList($id, $user);

        return ServiceResult::createSuccessResult($deleteProductFavoriteList);
    }

    public function getListFavoriteProducts(User $user, PaginationDTO $dto): ServiceResult
    {
        $listFavoriteProducts = $this->productRepository->listFavoriteProducts($user, $dto);

        return ServiceResult::createSuccessResult($listFavoriteProducts);
    }
}
