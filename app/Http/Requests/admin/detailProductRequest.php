<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class detailProductRequest extends FormRequest
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
            'color' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'sale_price' => 'nullable|integer|min:0|lte:price',
            'version' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'color.string' => 'Màu sắc phải là chuỗi ký tự.',
            'color.max' => 'Màu sắc không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.integer' => 'Giá sản phẩm phải là số nguyên.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'sale_price.integer' => 'Giá khuyến mãi phải là số nguyên.',
            'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',
            'version.string' => 'Phiên bản phải là chuỗi ký tự.',
            'version.max' => 'Phiên bản không được vượt quá 255 ký tự.',
        ];
    }
}
