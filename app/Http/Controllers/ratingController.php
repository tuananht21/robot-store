<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\reviewRequest;
use Illuminate\Support\Facades\Auth;

class ratingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(reviewRequest $request, string $slug)
    {
        //
        $params = $request->validated();

        $product = Product::where('slug', $slug)->firstOrFail();

        $detailOrder = DetailOrder::with('order')
            ->where('id', $params['detail_order_id'])
            ->where('detail_product_id', $params['detail_product_id'])
            ->first();

        if (!$detailOrder || !$detailOrder->order) {
            return back()->with('error', 'Đơn hàng không hợp lệ.');
        }

        if ($detailOrder->order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($detailOrder->order->status != 3) {
            return back()->with('error', 'Chỉ có thể đánh giá đơn hàng đã hoàn thành.');
        }

        if (!$product->detailProducts()
            ->where('id', $params['detail_product_id'])
            ->exists()) {
            return back()->with('error', 'Sản phẩm không hợp lệ.');
        }


        // tránh user đánh giá cùng một sản phẩm nhiều lần trong cùng đơn
        if (Review::where('detail_order_id', $detailOrder->id)
            ->where('detail_product_id', $params['detail_product_id'])
            ->exists()) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        Review::create([
            'detail_order_id' => $detailOrder->id,
            'detail_product_id' => $detailOrder->detail_product_id,
            'rating' => $params['rating'],
            'content' => $params['content'] ?? null,
        ]);

        return back()->with('success', 'Đánh giá sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $review = Review::with('detailOrder.order')->findOrFail($id);

        if (!$review->detailOrder || !$review->detailOrder->order) {
            return back()->with('error', 'Không tìm thấy đánh giá.');
        }

        if ($review->detailOrder->order->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Xóa đánh giá thành công!');
    }
}
