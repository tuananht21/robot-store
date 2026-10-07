<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class reviewRequest extends FormRequest
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
            'detail_order_id' => ['required', 'exists:detail_orders,id'],
            'detail_product_id' => ['required', 'exists:detail_products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'detail_order_id.required' => 'Vui lòng chọn đơn hàng.',
            'detail_order_id.exists' => 'Đơn hàng không tồn tại.',
            'detail_product_id.required' => 'Vui lòng chọn sản phẩm.',
            'detail_product_id.exists' => 'Sản phẩm không tồn tại.',
            'rating.required' => 'Vui lòng chọn số sao.',
            'rating.integer' => 'Số sao không hợp lệ.',
            'rating.min' => 'Đánh giá tối thiểu 1 sao.',
            'rating.max' => 'Đánh giá tối đa 5 sao.',
            'content.string' => 'Nội dung đánh giá không hợp lệ.',
            'content.max' => 'Nội dung đánh giá không được quá 1000 ký tự.',
        ];
    }
}
