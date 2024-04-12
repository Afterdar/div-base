<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Pagination\PaginationDTO;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\Product\ProductFavoriteListResource;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            ["bearerAuth" => []]
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


    /**
     * @throws \Exception
     */
    #[OAT\Post(
        path: "/api/v1/favourite/add/{id}",
        description: "Добавить в избранное",
        security: [
            ["bearerAuth" => []]
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
    public function addProductFavorite(int $id, Request $request): JsonResponse
    {
        $user = $request->user();

        $addProductFavoriteList = $this->productService->addProductFavoriteList($id, $user);

        if ($addProductFavoriteList->isError) {
            return response()->json($addProductFavoriteList->errors);
        }

        return response()->json('Товар добавлен в избраное');
    }

    #[OAT\Post(
        path: "/api/v1/favourite/delete/{id}",
        description: "Удалить из избранного",
        security: [
            ["bearerAuth" => []]
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
    public function deleteProductFavorite(int $id, Request $request): JsonResponse
    {
        $user = $request->user();

        $deleteProductFavoriteList = $this->productService->deleteProductFavoriteList($id, $user);

        if ($deleteProductFavoriteList->isError) {
            return response()->json($deleteProductFavoriteList->errors);
        }

        return response()->json('Товар удален из избраного');
    }

    #[OAT\Get(
        path: "/api/v1/favourite/list",
        description: "Получить список избранных товаров пользователя",
        security: [
            ["bearerAuth" => []]
        ],
        tags: ["Каталог"],

        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(

                    properties: [
                        new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/ProductFavoriteListResource'))
                    ],

                ),
            )
        ]
    )]
    public function listFavoriteProducts(Request $request, PaginationRequest $paginationRequest): JsonResource
    {
        $user = $request->user();
        $dto = PaginationDTO::fillAttributes($paginationRequest->validated());

        $listFavoriteProducts = $this->productService->getListFavoriteProducts($user, $dto);

        return ProductFavoriteListResource::collection($listFavoriteProducts->data);
    }
}
