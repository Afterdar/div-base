<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\CRUD\CategoryRepository;
use Exception;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getListCategory(): JsonResponse
    {
        $list = $this->categoryRepository->getListActiveCategory();

        return ResponseBuilder::success($list->toArray());
    }

    public function getCategoryById(int $id): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($id);

        if ($category === null)
        {
            throw new Exception('Категория по данному id не найдена');
        }

        return ResponseBuilder::success($category->toArray());
    }
}
