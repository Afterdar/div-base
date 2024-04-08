<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Users\UserLoginDTO;
use App\DTO\Users\UserRegisterDTO;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\UserLoginResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class UsersController extends BaseController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[OAT\Post(
        path: "/api/v1/user/register",
        description: "Регистрация",
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/UserRegisterDTO'
            ),
        ),
        tags: ["Авторизация"],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/UserRegisterResource'
                ),
            )
        ]
    )]
    public function register(UserRegisterRequest $userRegisterRequest): UserRegisterResource|JsonResponse
    {
        $dto = UserRegisterDTO::fillAttributes($userRegisterRequest->validated());

        $register = $this->userService->registerUser($dto);

        if ($register->isError) {
            return response()->json($register->errors);
        }

        return new UserRegisterResource($register->data);
    }

    #[OAT\Post(
        path: "/api/v1/user/login",
        description: "Авторизация",
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/UserLoginDTO'
            ),
        ),
        tags: ["Авторизация"],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/UserLoginResource'
                ),
            )
        ]
    )]
    public function login(UserLoginRequest $userLoginRequest): UserLoginResource|JsonResponse
    {
        $dto = UserLoginDTO::fillAttributes($userLoginRequest->validated());

        $login = $this->userService->loginUser($dto);

        if ($login->isError) {
            return response()->json($login->errors);
        }

        return new UserLoginResource($login->data);
    }

    #[OAT\Post(
        path: "/api/v1/user/send-verify-email",
        description: "Отправка письма для подтверждения",
        security: [
            ["sanctum" => []]
        ],
        tags: ["Авторизация"],
        responses: [
            new OAT\Response(
                response: 200,
                description: "OK",
                content: new OAT\JsonContent(),
            )
        ]
    )]
    public function sendVerifyEmail(Request $request): JsonResponse
    {
        $user = $request->user();
        $result = $this->userService->sendVerifyEmail($user);

        if ($result->isError) {
            return response()->json($result->errors);
        }

        return response()->json($result->data);
    }

    #[OAT\Get(
        path: "/api/v1/user/verify-email/{id}/{hash}",
        description: "Подтверждение почты",
        tags: ["Авторизация"],
        parameters: [
            new OAT\Parameter(name: 'id', in: 'path'),
            new OAT\Parameter(name: 'hash', in: 'path'),
        ],
        responses: [
            new OAT\Response(response: 200, description: "OK")
        ]
    )]
    public function verifyEmail(int $id): JsonResponse
    {
        $result = $this->userService->verifyUser($id);

        if ($result->isError) {
            return response()->json($result->errors);
        }

        return response()->json($result->data);
    }
}
