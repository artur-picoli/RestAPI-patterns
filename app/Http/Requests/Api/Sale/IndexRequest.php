<?php

namespace App\Http\Requests\Api\Sale;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['nullable', 'exists:customers,id', 'integer'],
            'car_id' => ['nullable', 'exists:cars,id', 'integer'],
            'start_price' => ['nullable', 'decimal:2'],
            'finish_price' => ['nullable', 'decimal:2', 'after_or_equal:start_price'],
            'brand_id' => ['nullable', 'exists:brands,id', 'integer'],
        ];
    }
}
