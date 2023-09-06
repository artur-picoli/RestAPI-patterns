<?php

namespace App\Http\Requests\Api\Car;

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
            'model' => ['nullable', 'string','max:255'],
            'start_year' => ['nullable', 'integer', 'digits:4', 'min:1900'],
            'finish_year' => ['nullable', 'integer', 'digits:4', 'after_or_equal:start_year'],
            'color' => ['nullable','string','max:50'],
            'brand_id' => ['nullable', 'string', 'exists:brands,id' ]
        ];
    }
}
