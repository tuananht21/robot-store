<?php

namespace App\Http\Requests\order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class orderValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Route for updating status
        if ($this->routeIs('admin.orders.status') || $this->has('status') && !$this->has('customer_name')) {
            return [
                'status' => [
                    'required',
                    'integer',
                    'in:1,2,3,4',
                ],
                'payment_status' => [
                    'nullable',
                    'boolean',
                ],
            ];
        }

        // Store route
        return [
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'payment_method' => [
                'nullable',
                'boolean',
            ],
            'items' => [
                'nullable',
                'array',
            ],
            'items.*.detail_product_id' => [
                'required_with:items',
                'integer',
                'exists:detail_products,id',
            ],
            'items.*.quantity' => [
                'required_with:items',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string' => 'Customer name must be a string.',
            'customer_name.max' => 'Customer name must not exceed 255 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number must not exceed 15 characters.',

            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address must not exceed 255 characters.',

            'payment_method.boolean' => 'Payment method must be boolean.',

            'items.array' => 'Items must be an array.',
            'items.*.detail_product_id.required_with' => 'Detail product ID is required in items.',
            'items.*.detail_product_id.exists' => 'Detail product not found in items.',
            'items.*.quantity.required_with' => 'Quantity is required in items.',
            'items.*.quantity.min' => 'Quantity in items must be at least 1.',

            'status.required' => 'Status is required.',
            'status.in' => 'Status must be 1 (pending), 2 (shipped), 3 (completed), or 4 (canceled).',
            'payment_status.boolean' => 'Payment status must be boolean.',
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
