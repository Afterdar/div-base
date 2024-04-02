<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\CRUD\SubCategoryRepository;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends BaseController
{
    private SubCategoryRepository $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function getListSubCategoriesByIdCategory(int $id): JsonResponse
    {
        $list = $this->subCategoryRepository->getListSubCategories($id);

        return ResponseBuilder::success($list->toArray());
    }

    public function getSubCategoryById(int $id): JsonResponse
    {
        $category = $this->subCategoryRepository->getSubCategoryById($id);

        if ($category === null)
        {
            throw new \Exception('Такой категории не существует');
        }

        return ResponseBuilder::success($category->toArray());
    }
}
