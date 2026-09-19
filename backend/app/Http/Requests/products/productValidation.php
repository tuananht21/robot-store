<?php

namespace App\Http\Requests\products;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class productValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'thumbnail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:products,slug,' . $productId,
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',

            'description.string' => 'Description must be a string.',

            'thumbnail.string' => 'Thumbnail must be a string.',
            'thumbnail.max' => 'Thumbnail must not exceed 255 characters.',

            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be true or false.',

            'slug.required' => 'Slug is required.',
            'slug.string' => 'Slug must be a string.',
            'slug.max' => 'Slug must not exceed 255 characters.',
            'slug.unique' => 'Slug already exists.',

            'category_id.required' => 'Category is required.',
            'category_id.integer' => 'Category ID must be an integer.',
            'category_id.exists' => 'Category not found.',
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