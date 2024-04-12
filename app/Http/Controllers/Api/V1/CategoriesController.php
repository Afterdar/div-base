<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Pagination\PaginationDTO;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductListResource;
use App\Repositories\CRUD\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAT;

class CategoriesController extends BaseController
{
    private CategoryRepository $categoryRepository;
    private CategoryService $categoryService;

    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    #[OAT\Get(
        path: "/api/v1/categories/list",
        description: "Получить список категорий",
        security: [
            ["bearerAuth" => []]
        ],
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

    #[OAT\Get(
        path: "/api/v1/categories/products/list/{id}",
        description: "Получить продукты категории",
        security: [
            ["bearerAuth" => []]
        ],
        tags: ["Каталог"],
        parameters: [
            new OAT\Parameter(name: 'id', in: 'path'),
            new OAT\Parameter(name: 'page', in: 'query', required: false, schema: new OAT\Schema(type: 'integer', default: 1)),
            new OAT\Parameter(name: 'perPage', in: 'query', required: false, schema: new OAT\Schema(type: 'integer')),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(
                    allOf: [
                        new OAT\Schema(
                            ref: '#/components/schemas/PaginationDTO'
                        ),
                        new OAT\Schema(
                            properties: [
                                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/ProductListResource'))
                            ],
                        ),
                    ]
                ),
            )
        ]
    )]
    public function getProductsListCategory(int $id, PaginationRequest $paginationRequest): JsonResource
    {
        $user = auth('sanctum')->user();

        $dto = PaginationDTO::fillAttributes($paginationRequest->validated());

        $listProducts = $this->categoryService->getListCategoryProducts($id, $dto, $user);

        return ProductListResource::collection($listProducts->data);
    }
}
