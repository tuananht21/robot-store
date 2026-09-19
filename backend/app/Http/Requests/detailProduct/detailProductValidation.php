<?php

namespace App\Http\Requests\detailProduct;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class detailProductValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'price' => [
                'required',
                'integer',
                'min:0',
            ],
            'sale_price' => [
                'nullable',
                'integer',
                'min:0',
                'lte:price',
            ],
            'version' => [
                'nullable',
                'string',
                'max:255',
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.integer' => 'Product ID must be an integer.',
            'product_id.exists' => 'Product not found.',
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be an integer.',
            'price.min' => 'Price must be at least 0.',
            'sale_price.integer' => 'Sale price must be an integer.',
            'sale_price.min' => 'Sale price must be at least 0.',
            'sale_price.lte' => 'Sale price must be less than or equal to price.',
            'version.string' => 'Version must be a string.',
            'version.max' => 'Version must not exceed 255 characters.',
            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be an integer.',
            'stock.min' => 'Stock must be at least 0.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->all();

        throw new ValidationException(
            $validator,
            response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => implode(' and ', $errors),
            ], 400)
        );
    }
}
