<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Throwable;

class AiChatController extends Controller
{
    //
    public function chat(Request $request, GeminiService $geminiService)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Lấy toàn bộ sản phẩm đang hoạt động cùng thông tin liên quan.
        // Dữ liệu này sẽ được cung cấp cho AI để trả lời các câu hỏi về sản phẩm.
        $products = Product::with([
            'category',
            'detailProducts.inStock',
        ])->where('status', true)->get();

        // Chuyển dữ liệu sản phẩm từ Eloquent Model sang dữ liệu đơn giản
        // để có thể gửi sang Gemini dưới dạng JSON.
        $context = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'category' => $product->category?->name,
                'description' => $product->description,
                // Lấy thông tin từng phiên bản của sản phẩm.
                'details' => $product->detailProducts->map(function ($detail) {
                    return [
                        'version' => $detail->version,
                        'color' => $detail->color,
                        'price' => $detail->price,
                        'sale_price' => $detail->sale_price,
                        // Nếu không có bản ghi tồn kho thì mặc định là 0.
                        'stock' => $detail->inStock?->stock ?? 0,
                    ];
                }),
            ];
        });

        // Gửi câu hỏi của người dùng cùng dữ liệu sản phẩm cho GeminiService.
        // json_encode() chuyển dữ liệu sản phẩm thành JSON để AI dễ đọc.
        $message = $geminiService->chat(
            $request->message,
            json_encode($context, JSON_UNESCAPED_UNICODE)
        );

        // Trả kết quả từ Gemini về frontend dưới dạng JSON.
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}