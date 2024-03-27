<?php

namespace App\DTO\Common;

use Illuminate\Support\Collection;

abstract class BaseDTOCollection
{
    protected Collection $items;

    abstract public function getDTOInstance(array $attributes): BaseDTO;

    public function __construct(array $items)
    {
        $this->items = collect();
        $this->buildItems($items);
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    protected function buildItems(array $items): void
    {
        foreach ($items as $item) {
            $this->items->add($this->getDTOInstance($item));
        }
    }

    public function toArray(?\Closure $keyCreateCallback = null): array
    {
        $result = [];

        foreach ($this->items as $item) {
            $result[] = $item->toArray($keyCreateCallback);
        }

        return $result;
    }

    public function getCollectionOfAttributeValues(string $attribute): Collection
    {
        $result = collect();

        foreach ($this->items as $item) {
            if (property_exists($item, $attribute)) {
                $result->add($item->$attribute);
            }
        }

        return $result;
    }
}
