<?php

namespace App\DTO\Users;

use App\DTO\Common\BaseDTO;
use App\Models\User;

class UserTokenDTO extends BaseDTO
{
    public function __construct(
        readonly User   $user,
        readonly string $token,
    )
    {
    }
}
