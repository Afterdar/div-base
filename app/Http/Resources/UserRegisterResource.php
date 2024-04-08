<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "UserDTOResource",
    title: 'UserDTOResource',
    properties: [
        new Property(property: 'user', ref: '#/components/schemas/UserResource'),
        new Property(property: 'token', type: 'string'),
    ]
)]
class UserRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'token' => $this->token
        ];
    }
}