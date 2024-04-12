<?php

namespace App\Services;

use App\DTO\Pagination\PaginationDTO;
use App\Models\User;
use App\Repositories\CRUD\CategoryRepository;
use App\Repositories\CRUD\ProductRepository;
use App\Services\Common\ServiceResult;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getListCategoryProducts(int $id, PaginationDTO $dto, ?User $user): ServiceResult
    {
        $listProducts = $this->categoryRepository->getListProductsCategory($id, $dto, $user);

        if (!$listProducts)
        {
            return ServiceResult::createErrorResult('Категория не найдена', status: 404);
        }

//        $resultListProducts = [];
//
//        foreach ($listProducts as $product)
//        {
//            $test = $product->toArray();
//
//            foreach ($test['image'] as $image)
//            {
//                $test['image'][] =  asset('storage/' . $image);
//            }
//
//            $resultListProducts[] = $test;
//        }
//
//        dd($resultListProducts);

        return ServiceResult::createSuccessResult($listProducts);
    }

}
