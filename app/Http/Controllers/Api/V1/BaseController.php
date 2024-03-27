<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use OpenApi\Attributes as OAT;

#[OAT\OpenApi(
    info: new OAT\Info(
        version: "1.0",
        description: 'Документация',
        title: "Api"
    ),
)]
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
