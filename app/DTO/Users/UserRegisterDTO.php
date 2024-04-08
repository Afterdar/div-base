<?php

namespace App\DTO\Users;

use App\DTO\Common\BaseDTO;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "UserRegisterDTO",
    title: 'UserRegisterDTO',
    required: ['email', 'password', 'name'],
    properties: [
        new Property(property: 'name', type: 'string'),
        new Property(property: 'email', type: 'string'),
        new Property(property: 'password', type: 'string'),
    ]
)]
class UserRegisterDTO extends BaseDTO
{
    public function __construct(
        readonly string $name,
        readonly string $email,
        readonly string $password,
    )
    {

    }
}
