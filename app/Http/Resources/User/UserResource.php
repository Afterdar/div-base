<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "UserResource",
    title: 'UserResource',
    properties: [
        new Property(property: 'id', type: 'integer'),
        new Property(property: 'name', type: 'string'),
        new Property(property: 'email', type: 'string'),
        new Property(property: 'updatedAt', type: 'string', format: 'date-time'),
        new Property(property: 'createdAt', type: 'string', format: 'date-time'),
    ]
)]
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "updatedAt" => $this->updated_at,
            "createdAt" => $this->created_at,
        ];
    }
}
