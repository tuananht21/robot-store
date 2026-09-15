<?php

namespace App\Http\Requests\category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class categoryValidation extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name must not exceed 255 characters.',
            'slug.required' => 'Slug is required.',
            'slug.max' => 'Slug must not exceed 255 characters.',
            'slug.unique' => 'Slug already exists.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new \Illuminate\Validation\ValidationException(
            $validator,
            response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => implode(' and ', $errors),
            ], 400)
        );
    }
}

