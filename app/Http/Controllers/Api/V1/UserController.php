<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\User\RegisterUserRequest;
use App\Repositories\CRUD\UserRepository;
use Exception;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserRequest $registerUserRequest): JsonResponse
    {
        $user = $this->userRepository->registerUser($registerUserRequest);

        if ($user === false)
        {
            throw new Exception('Ошибка регистрации пользователя');
        }

        return ResponseBuilder::success(['Пользователь зарегистрирован']);
    }
}
