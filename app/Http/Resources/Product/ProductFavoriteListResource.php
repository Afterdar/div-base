<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "ProductFavoriteListResource",
    title: 'ProductFavoriteListResource',
    properties: [
        new Property(property: 'id', type: 'integer'),
        new Property(property: 'title', type: 'string'),
        new Property(property: 'price', type: 'integer'),
        new Property(property: 'image', type: 'array', items: new Items(type: 'string')),
        new Property(property: 'active', type: 'boolean'),
        new Property(property: 'order', type: 'integer'),
        new Property(property: 'updatedAt', type: 'string', format: 'date-time'),
        new Property(property: 'createdAt', type: 'string', format: 'date-time'),
    ]
)]
class ProductFavoriteListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resultImage = [];

        foreach ($this->image as $image)
        {
            $resultImage[] = asset('storage/' . $image);
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "image" => $resultImage,
            "active" => $this->active,
            "order" => $this->order,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
