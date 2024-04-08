<?php

namespace App\Repositories\CRUD;

use App\DTO\Users\UserLoginDTO;
use App\DTO\Users\UserRegisterDTO;
use App\Models\User;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseCRUDRepository
{

    public function getModelsQB(): Builder
    {
        return User::query();
    }

    public function registerUser(UserRegisterDTO $dto): Model|Builder|Authenticatable
    {
        return $this->getModelsQB()
            ->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
            ]);
    }

    public function getUserByEmail(UserLoginDTO $dto): Model|null
    {
        return $this->getModelsQB()
            ->where('email', '=', $dto->email)
            ->first();
    }

    public function getUserById(int $id): Model|null
    {
        return $this->getModelsQB()
            ->where('id', '=', $id)
            ->first();
    }
}
