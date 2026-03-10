<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => 'required|array|max:5',
            'products.*.name' => 'required|string',
            'products.*.descriptions' => 'required|array|max:3',
            'products.*.descriptions.*.text' => 'required|string',
            'products.*.descriptions.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'products.*.descriptions.*.image.mimes' => 'File harus berupa JPG, JPEG, atau PNG',
        ];
    }
}
