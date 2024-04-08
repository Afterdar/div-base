<?php

namespace App\Services;

use App\DTO\Users\UserLoginDTO;
use App\DTO\Users\UserRegisterDTO;
use App\DTO\Users\UserTokenDTO;
use App\Models\User;
use App\Repositories\CRUD\UserRepository;
use App\Services\Common\ServiceResult;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(UserRegisterDTO $dto): ServiceResult
    {
        $user = $this->userRepository->registerUser($dto);
        event(new Registered($user));

        $result = UserTokenDTO::fillAttributes([
            'user' => $user,
            'token' => $user->createToken($user['name'])->plainTextToken
        ]);

        return ServiceResult::createSuccessResult($result);
    }

    public function loginUser(UserLoginDTO $dto): ServiceResult
    {
        $user = $this->userRepository->getUserByEmail($dto);

        if (!$user || !Hash::check($dto->password, $user['password'])) {
            return ServiceResult::createErrorResult('Неверный логин или пароль');
        }

        $result = UserTokenDTO::fillAttributes([
            'user' => $user,
            'token' => $user->createToken($user['name'])->plainTextToken
        ]);

        return ServiceResult::createSuccessResult($result);
    }

    public function sendVerifyEmail(User $user): ServiceResult
    {
        $user->sendEmailVerificationNotification();

        return ServiceResult::createSuccessResult('Письмо отправлено');
    }

    public function verifyUser(int $id): ServiceResult
    {
        $user = $this->userRepository->getUserById($id);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return ServiceResult::createSuccessResult('Почта подтверждена');
    }
}
