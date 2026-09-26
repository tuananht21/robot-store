<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = null;
        $filterStatus = 'all';

        if ($request->has('search')) {
            $search = $request->input('search');
        }

        if ($request->has('filter_status')) {
            $filterStatus = $request->input('filter_status');
        }

        $orders = Order::with([
            'detailOrders',
            'detailOrders.detailProduct.product',
            'detailOrders.detailProduct.product.category'
        ])->orderBy('id', 'desc');

        if ($filterStatus !== 'all') {
            $orders = $orders->where('status', $filterStatus);
        }

        if ($search) {
            $orders = $orders->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $orders = $orders->paginate(10)->appends([
            'search' => $search,
            'filter_status' => $filterStatus
        ]);

        return view('admin.pages.orders.index', compact('orders', 'filterStatus'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with([
            'detailOrders.detailProduct.product',
            'detailOrders.detailProduct.inStock',
            'user'
        ])->findOrFail($id);

        return view('admin.pages.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $status = (int) $request->input('status');

        if ($status < 1 || $status > 4) {
            return back()->with('error', 'Trạng thái đơn hàng không hợp lệ!');
        }

        if ($order->status >= $status) {
            return back()->with('error', 'Không thể cập nhật trạng thái này!');
        }

        $order->status = $status;

        if ($status === 3) {
            $order->payment_status = true;
        }

        if ($status === 4) {
            $order->payment_status = false;
        }

        $order->save();

        return back()->with('success', 'Cập nhật đơn hàng thành công!');
    }
}