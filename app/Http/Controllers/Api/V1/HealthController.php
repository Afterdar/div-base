<?php

namespace App\Http\Controllers\Api\V1;

use OpenApi\Attributes as OAT;

class HealthController extends BaseController
{

    #[OAT\Get(
        path: "/api/v1/health",
        description: "Здоровье апи",
        summary: "Система",
        tags: ["Система"],
        responses: [
            new OAT\Response(response: 200, description: "OK")
        ]
    )]
    public function index()
    {
        return [];
    }
}
