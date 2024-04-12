<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "CategoryResource",
    title: 'CategoryResource',
    properties: [
        new Property(property: 'id', type: 'integer'),
        new Property(property: 'title', type: 'string'),
        new Property(property: 'order', type: 'integer'),
        new Property(property: 'active', type: 'boolean'),
        new Property(property: 'image', type: 'array', items: new Items(type: 'string')),
        new Property(property: 'parentId', type: 'integer', nullable: true),
        new Property(property: 'updatedAt', type: 'string', format: 'date-time'),
        new Property(property: 'createdAt', type: 'string', format: 'date-time'),
    ]
)]

class CategoryResource extends JsonResource
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
            "title" => $this->title,
            "order" => $this->order,
            "active" => $this->active,
            "image" => $this->image,
            "parentId" => $this->parent_id,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
