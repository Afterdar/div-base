<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Pagination\PaginationDTO;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAT;

class ProductsController extends BaseController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[OAT\Get(
        path: "/api/v1/products/{id}",
        description: "Получить продукт по id",
        security: [
            ["sanctum" => []],
        ],
        tags: ["Каталог"],
        parameters: [
            new OAT\Parameter(name: 'id', in: 'path'),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(property: 'data', ref: '#/components/schemas/ProductResource')
                    ]
                ),
            )
        ]
    )]

    public function getProductById(int $id): ProductResource|JsonResponse
    {
        $product = $this->productService->getProductById($id);

        if ($product->isError) {
            return response()->json($product->errors);
        }

        return new ProductResource($product->data);
    }

    #[OAT\Get(
        path: "api/v1/products/list/{id}",
        description: "Получить продукты категории",
        security: [
            ["sanctum" => []],
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
                            ref: '#/components/schemas/Pagination'
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

    public function getProductsListCategory(int $id, PaginationRequest $paginationRequest): AnonymousResourceCollection
    {
        $dto = PaginationDTO::fillAttributes($paginationRequest->validated());

        $listProducts = $this->productService->getListProductsCategory($id, $dto);

        return ProductListResource::collection($listProducts->data);
    }

    /**
     * @throws \Exception
     */
    #[OAT\Post(
        path: "api/v1/favourite/add/{id}",
        description: "Добавить в избранное",
        security: [
            ["sanctum" => []]
        ],
        tags: ["Каталог"],
        parameters: [
            new OAT\Parameter(name: 'id', in: 'path'),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(),
            )
        ]
    )]

    public function addProductFavorite(int $id): JsonResponse
    {
        $user = Auth()->user();

        $addProductFavoriteList = $this->productService->addProductFavoriteList($id, $user);

        if ($addProductFavoriteList->isError) {
            return response()->json($addProductFavoriteList->errors);
        }

        return response()->json('Товар добавлен в избраное');
    }

    #[OAT\Post(
        path: "api/v1/favourite/delete/{id}",
        description: "Удалить из избранного",
        security: [
            ["sanctum" => []]
        ],
        tags: ["Каталог"],
        parameters: [
            new OAT\Parameter(name: 'id', in: 'path'),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(),
            )
        ]
    )]

    public function deleteProductFavorite(int $id): JsonResponse
    {
        $user = Auth()->user();

        $deleteProductFavoriteList = $this->productService->deleteProductFavoriteList($id, $user);

        if ($deleteProductFavoriteList->isError) {
            return response()->json($deleteProductFavoriteList->errors);
        }

        return response()->json('Товар удален из избраного');
    }
}
