<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use OpenApi\Attributes as OAT;

/**
 * @OA\Swagger(
 *      schemes={"http"},
 *      basePath="/api/v1",
 *      @OA\Info(
 *          title="Div-base",
 *          version="1.0.0",
 *      ),
 *      @OA\PathItem(path="/api")
 *
 *     @OA\Compontents(
 *          @OA\SecurityScheme(
 *              securityScheme="bearerAuth",
 *              type="http",
 *              scheme="bearer"
 *          )
 *      )
 * )
 */
class BaseController extends Controller
{
    public function errorResponse(
        string $message,
        array  $errors = [],
        int    $status = 400,
        ?array $additional = null,
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            ...($additional ?? []),
        ], $status);
    }

    public function emptyResponse(): JsonResponse
    {
        return response()->json();
    }
}
