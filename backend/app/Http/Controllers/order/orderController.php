<?php

namespace App\Http\Controllers\order;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\order\orderValidation;
use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\DetailProduct;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $orders = Order::with(['details.detailProduct.product'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            return ApiResponse::success($orders, 'Get user orders successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get user orders.', 500);
        }
    }

    /**
     * Display specified order for user.
     */
    public function show(string $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $order = Order::with(['details.detailProduct.product'])
                ->where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$order) {
                return ApiResponse::error('Order not found.', 404);
            }

            return ApiResponse::success($order, 'Get order details successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get order details.', 500);
        }
    }

    /**
     * Create a new order.
     */
    public function store(orderValidation $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $itemsToProcess = [];
            $isFromCart = false;

            if ($request->has('items') && is_array($request->items) && count($request->items) > 0) {
                $itemsToProcess = $request->items;
            } else {
                $isFromCart = true;
                $cartItems = Cart::where('user_id', $user->id)->get();

                if ($cartItems->isEmpty()) {
                    DB::rollBack();
                    return ApiResponse::error('Cart is empty.', 400);
                }

                foreach ($cartItems as $cItem) {
                    $itemsToProcess[] = [
                        'detail_product_id' => $cItem->detail_product_id,
                        'quantity' => $cItem->quantity,
                    ];
                }
            }

            $totalAmount = 0;
            $orderItems = [];

            foreach ($itemsToProcess as $item) {
                $detailProduct = DetailProduct::lockForUpdate()->find($item['detail_product_id']);

                if (!$detailProduct) {
                    DB::rollBack();
                    return ApiResponse::error("Detail product ID {$item['detail_product_id']} not found.", 404);
                }

                if ($detailProduct->stock < $item['quantity']) {
                    DB::rollBack();
                    return ApiResponse::error("Insufficient stock for detail product ID {$detailProduct->id}.", 400);
                }

                $price = $detailProduct->sale_price ?? $detailProduct->price;
                $totalAmount += $price * $item['quantity'];

                // Deduct stock
                $detailProduct->decrement('stock', $item['quantity']);

                $orderItems[] = [
                    'detail_product_id' => $detailProduct->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method ?? true,
                'payment_status' => false,
                'status' => 1, // 1: pending
            ]);

            foreach ($orderItems as $oItem) {
                DetailOrder::create([
                    'order_id' => $order->id,
                    'detail_product_id' => $oItem['detail_product_id'],
                    'quantity' => $oItem['quantity'],
                    'price' => $oItem['price'],
                ]);
            }

            if ($isFromCart) {
                Cart::where('user_id', $user->id)->delete();
            }

            DB::commit();

            $order->load(['details.detailProduct.product']);

            return ApiResponse::success($order, 'Create order successfully.', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error('Failed to create order.', 500);
        }
    }

    /**
     * Admin: Display all orders in the system.
     */
    public function adminIndex()
    {
        try {
            $orders = Order::with(['user', 'details.detailProduct.product'])
                ->latest()
                ->get();

            return ApiResponse::success($orders, 'Get all orders successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get orders.', 500);
        }
    }

    /**
     * Admin: Update status or payment status of an order.
     */
    public function updateStatus(orderValidation $request, string $id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('details.detailProduct')->find($id);

            if (!$order) {
                DB::rollBack();
                return ApiResponse::error('Order not found.', 404);
            }

            $newStatus = (int) $request->status;
            $oldStatus = (int) $order->status;

            // If order status changed to 4 (canceled) from another status, restore stock
            if ($newStatus === 4 && $oldStatus !== 4) {
                foreach ($order->details as $detail) {
                    if ($detail->detailProduct) {
                        $detail->detailProduct->increment('stock', $detail->quantity);
                    }
                }
            }

            $updateData = ['status' => $newStatus];
            if ($request->has('payment_status')) {
                $updateData['payment_status'] = $request->payment_status;
            }

            $order->update($updateData);

            DB::commit();

            $order->load(['user', 'details.detailProduct.product']);

            return ApiResponse::success($order, 'Update order status successfully.', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error('Failed to update order status.', 500);
        }
    }
}
