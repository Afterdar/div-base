<?php

namespace App\DTO\Pagination;

use App\DTO\Common\BaseDTO;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: "PaginationDTO",
    title: 'PaginationDTO',
    required: [],
    properties: [
        new Property(property: 'page', type: 'integer'),
        new Property(property: 'perPage', type: 'integer'),
    ]
)]
class PaginationDTO extends BaseDTO
{
    public function __construct(
        readonly int $page = 1,
        readonly int $perPage = 15,
    )
    {
    }
}
