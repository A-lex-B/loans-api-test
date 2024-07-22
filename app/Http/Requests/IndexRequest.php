<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter' => 'array|nullable',
            'filter.created_at' => 'array|nullable',
            'filter.created_at.from' => 'integer|nullable',
            'filter.created_at.to' => 'integer|nullable',
            'filter.amount' => 'array|nullable',
            'filter.amount.from' => 'integer|nullable|gt:0',
            'filter.amount.to' => 'integer|nullable|gt:0'
        ];
    }
}
