<?php

namespace App\Jobs;

use App\Events\OrderProcessed;
use App\Events\UserOrderBroadcast;
use App\Mail\checkoutEmail;
use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\InStock;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessCheckout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $params;
    public $orderID;

    public function __construct($user, $params = [], $orderID = null)
    {
        $this->user = $user;
        $this->params = $params;
        $this->orderID = $orderID;
    }

    public function handle(): void
    {
        try {

            DB::beginTransaction();

            if ($this->orderID) {
                $order = Order::findOrFail($this->orderID);
                // Chỉ xử lý xuất kho khi đơn hàng đã thanh toán thành công
                if (!$order->payment_status) {
                    throw new \Exception('Đơn hàng chưa thanh toán.');
                }
                // Lấy danh sách sản phẩm trong đơn hàng
                $detailOrders = DetailOrder::where('order_id', $order->id)->with('detailProduct')->get();

                if ($detailOrders->isEmpty()) {
                    throw new \Exception('Đơn hàng chưa có sản phẩm.');
                }
            } else {
                // Trường hợp checkout trực tiếp từ giỏ hàng thì lấy toàn bộ 
                // sản phẩm hiện có trong giỏ của user để tạo Order mới
                $cart = Cart::where('user_id', $this->user->id)->with('detailProduct')->get();

                if ($cart->isEmpty()) {
                    throw new \Exception('Giỏ hàng đang trống.');
                }
                // Tính tổng tiền sản phẩm trước khi cộng phí vận chuyển
                $totalAmount = $cart->sum(function ($item) {
                    return $item->quantity * $item->detailProduct->price;
                });

                $shippingFee = $this->params['shipping_fee'] ?? 0;
                // Tạo đơn hàng với trạng thái chưa thanh toán
                $order = Order::create([
                    'user_id' => $this->user->id,
                    'customer_name' => $this->params['name'],
                    'phone' => $this->params['phone'],
                    'address' => $this->params['address'] . ', ' . $this->params['ward'] . ', ' . $this->params['provinces'],
                    'note' => $this->params['note'] ?? null,
                    'total_amount' => $totalAmount + $shippingFee,
                    'shipping_fee' => $shippingFee,
                    'payment_method' => true,
                    'payment_status' => false,
                    'status' => 1,
                ]);
                
                foreach ($cart as $item) {
                    DetailOrder::create([
                        'order_id' => $order->id,
                        'detail_product_id' => $item->detail_product_id,
                        'quantity' => $item->quantity,
                        'sum_price' => $item->quantity * $item->detailProduct->price,
                    ]);
                }
                $detailOrders = DetailOrder::where('order_id', $order->id)->with('detailProduct')->get();
            }
            // Kiểm tra và trừ tồn kho cho từng sản phẩm trong đơn hàng
            foreach ($detailOrders as $detailOrder) {
                $inStocks = InStock::where('detail_product_id', $detailOrder->detail_product_id)
                    ->where('stock', '>', 0)->lockForUpdate()->orderBy('id')->get();

                $availableStock = $inStocks->sum('stock');

                if ($availableStock < $detailOrder->quantity) {
                    throw new \Exception('Sản phẩm không đủ số lượng trong kho.');
                }

                $remaining = $detailOrder->quantity;

                foreach ($inStocks as $inStock) {
                    if ($remaining <= 0) {
                        break;
                    }
                    
                    $quantity = min($remaining, $inStock->stock);

                    $inStock->stock -= $quantity;
                    $inStock->save();

                    $remaining -= $quantity;
                }
            }

            foreach ($detailOrders as $detailOrder) {
                $cartItem = Cart::where('user_id', $this->user->id)
                    ->where('detail_product_id', $detailOrder->detail_product_id)->first();

                if (!$cartItem) {
                    continue;
                }

                if ($cartItem->quantity <= $detailOrder->quantity) {
                    $cartItem->delete();
                } else {
                    $cartItem->quantity -= $detailOrder->quantity;
                    $cartItem->save();
                }
            }

            DB::commit();
            // Gửi email xác nhận đơn hàng
            Mail::to($this->user->email)->send(new checkoutEmail($order));
            event(new OrderProcessed('success', 'Đặt hàng thành công.', $this->user->id));
            event(new UserOrderBroadcast($order->id, 'success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('ProcessCheckout failed', [
                'user_id' => $this->user->id,
                'order_id' => $this->orderID,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}