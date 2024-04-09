<?php

namespace App\Services;

use App\DTO\Pagination\PaginationDTO;
use App\Repositories\CRUD\ProductRepository;
use App\Services\Common\ServiceResult;
use Illuminate\Contracts\Auth\Authenticatable;

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
    public function addProductFavoriteList(int $id, ?Authenticatable $user): ServiceResult
    {
        $addProductFavoriteList = $this->productRepository->addProductFavoriteList($id, $user);

        return ServiceResult::createSuccessResult($addProductFavoriteList);
    }

    public function deleteProductFavoriteList(int $id, ?Authenticatable $user): ServiceResult
    {
        $deleteProductFavoriteList = $this->productRepository->deleteProductFavoriteList($id, $user);

        return ServiceResult::createSuccessResult($deleteProductFavoriteList);
    }
}
