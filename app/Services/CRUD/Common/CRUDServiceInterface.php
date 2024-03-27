<?php

namespace App\Services\CRUD\Common;

use App\Services\Common\ServiceResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

interface CRUDServiceInterface
{
    public function create(array $properties): ServiceResult;

    public function read(?int $modelId): ServiceResult;

    public function update(array $properties, int $modelId): ServiceResult;

    public function delete(int $modelId): ServiceResult;

    public function processSave(array $properties, Model $model): ServiceResult;

    public function validateProperties(array $properties): Validator;
}
