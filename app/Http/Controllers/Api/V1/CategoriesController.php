<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Pagination\PaginationDTO;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CRUD\CategoryRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAT;

class CategoriesController extends BaseController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[OAT\Get(
        path: "/api/v1/categories/list",
        description: "Получить список категорий",
        tags: ["Каталог"],
        parameters: [
            new OAT\Parameter(name: 'page', in: 'query', required: false, schema: new OAT\Schema(type: 'integer', default: 1)),
            new OAT\Parameter(name: 'perPage', in: 'query', required: false, schema: new OAT\Schema(type: 'integer', default: 15)),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            )
        ]
    )]
    public function getListCategories(PaginationRequest $paginationRequest): JsonResource
    {
        $dto = PaginationDTO::fillAttributes($paginationRequest->validated());

        $listCategories = $this->categoryRepository->getListCategories($dto);

        return CategoryResource::collection($listCategories);
    }
}
