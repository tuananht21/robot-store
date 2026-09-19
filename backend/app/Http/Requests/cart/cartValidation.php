<?php

namespace App\Http\Requests\cart;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class cartValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // If route is updating cart item directly (e.g. PUT /carts/{id}), detail_product_id may be optional
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'detail_product_id' => [
                $isUpdate ? 'nullable' : 'required',
                'integer',
                'exists:detail_products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'detail_product_id.required' => 'Detail product ID is required.',
            'detail_product_id.integer' => 'Detail product ID must be an integer.',
            'detail_product_id.exists' => 'Detail product not found.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least 1.',
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
