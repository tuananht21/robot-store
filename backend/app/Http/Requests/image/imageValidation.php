<?php

namespace App\Http\Requests\image;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class imageValidation extends FormRequest
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
            'image' => [
                'nullable',
                'required_without:path',
                'image',
                'mimes:jpeg,png,jpg,gif,webp,svg',
                'max:2048',
            ],
            'path' => [
                'nullable',
                'required_without:image',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.integer' => 'Product ID must be an integer.',
            'product_id.exists' => 'Product not found.',
            'image.required_without' => 'Either image file or image path is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image format must be jpeg, png, jpg, gif, webp, or svg.',
            'image.max' => 'Image size must not exceed 2MB.',
            'path.required_without' => 'Either image file or image path is required.',
            'path.string' => 'Path must be a string.',
            'path.max' => 'Path must not exceed 255 characters.',
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
