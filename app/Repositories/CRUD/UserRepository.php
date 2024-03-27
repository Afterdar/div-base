<?php

namespace App\Repositories\CRUD;

use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use App\Repositories\CRUD\Common\BaseCRUDRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseCRUDRepository
{
    public function getModelsQB(): Builder
    {
        return User::query();
    }

    public function registerUser(RegisterUserRequest $registerUserRequest): bool
    {
        return $this->getModelsQB()
            ->insert([
                'name' => $registerUserRequest['name'],
                'email' => $registerUserRequest['email'],
                'password' => Hash::make($registerUserRequest['password']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
