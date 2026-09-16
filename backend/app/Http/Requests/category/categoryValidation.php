<?php

namespace App\Http\Requests\category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class categoryValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route("id");
        return [
            "name" => "required|string|max:255",
            "slug" => [
                "required",
                "string",
                "max:255",
                Rule::unique("categories", "slug")->ignore($categoryId),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            "name.required" => "Name is required.",
            "name.max" => "Name must not exceed 255 characters.",
            "slug.required" => "Slug is required.",
            "slug.max" => "Slug must not exceed 255 characters.",
            "slug.unique" => "Slug already exists.",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new \Illuminate\Validation\ValidationException(
            $validator,
            response()->json(
                [
                    "status" => false,
                    "statusCode" => 400,
                    "message" => implode(" and ", $errors),
                ],
                400
            )
        );
    }
}
