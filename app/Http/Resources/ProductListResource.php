<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;


#[Schema(
    schema: "ProductListResource",
    title: 'ProductListResource',
    properties: [
        new Property(property: 'id', type: 'integer'),
        new Property(property: 'title', type: 'string'),
        new Property(property: 'price', type: 'integer'),
        new Property(property: 'image', type: 'array', items: new Items(type: 'string')),
        new Property(property: 'active', type: 'boolean'),
        new Property(property: 'order', type: 'integer'),
        new Property(property: 'updatedAt', type: 'string', format: 'date-time'),
        new Property(property: 'createdAt', type: 'string', format: 'date-time'),
        new Property(property: 'productId', type: 'integer'),
        new Property(property: 'categoryId', type: 'integer'),
    ]
)]
class ProductListResource extends JsonResource
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
            "price" => $this->price,
            "image" => $this->image,
            "active" => $this->active,
            "order" => $this->order,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "productId" => $this->product_id,
            "categoryId" => $this->category_id,
        ];
    }
}
