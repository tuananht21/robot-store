<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['thumbnail'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['thumbnail'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.string' => 'Tên sản phẩm phải là chuỗi.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'thumbnail.required' => 'Vui lòng chọn ảnh sản phẩm.',
            'thumbnail.image' => 'Thumbnail phải là hình ảnh.',
            'thumbnail.mimes' => 'Thumbnail phải có định dạng jpg, jpeg, png hoặc webp.',
            'thumbnail.max' => 'Thumbnail không được vượt quá 2MB.',
            'status.required' => 'Trạng thái sản phẩm không được để trống.',
            'status.boolean' => 'Trạng thái sản phẩm không hợp lệ.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',
        ];
    }
}
