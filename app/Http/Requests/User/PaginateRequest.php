<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Exception;

class PaginateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'perPage' => ['required', 'int', 'min:1', 'max:20'],
        ];
    }

    /**
     * @throws Exception
     */
    public function messages(): array
    {
        return [
            'perPage.required' => $this->getMessage('required'),
            'perPage.string' => $this->getMessage('int'),
            'perPage.max' => $this->getMessage('max'),
            'perPage.min' => $this->getMessage('min'),
        ];
    }
}
