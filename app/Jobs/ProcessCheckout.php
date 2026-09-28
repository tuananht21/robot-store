<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\InStock;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        DB::beginTransaction();

        try {
            $cart = Cart::where('user_id', $this->user->id)
                ->with('detailProduct')
                ->get();

            if ($cart->isEmpty()) {
                throw new \Exception('Giỏ hàng đang trống.');
            }

            if ($this->orderID) {
                $order = Order::findOrFail($this->orderID);
            } else {
                $totalAmount = $cart->sum(function ($item) {
                    return $item->quantity * $item->detailProduct->price;
                });

                $shippingFee = $this->params['shipping_fee'] ?? 0;

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
            }

            foreach ($cart as $item) {
                $inStocks = InStock::where('detail_product_id', $item->detail_product_id)
                    ->where('stock', '>', 0)
                    ->lockForUpdate()
                    ->orderBy('id')
                    ->get();

                $availableStock = $inStocks->sum('stock');

                if ($availableStock < $item->quantity) {
                    throw new \Exception('Sản phẩm không đủ số lượng trong kho.');
                }

                $remaining = $item->quantity;

                foreach ($inStocks as $inStock) {
                    if ($remaining <= 0) {
                        break;
                    }

                    $quantity = min($remaining, $inStock->stock);

                    $inStock->stock -= $quantity;
                    $inStock->save();

                    $remaining -= $quantity;
                }

                DetailOrder::create([
                    'order_id' => $order->id,
                    'detail_product_id' => $item->detail_product_id,
                    'quantity' => $item->quantity,
                    'sum_price' => $item->quantity * $item->detailProduct->price,
                ]);
            }

            Cart::where('user_id', $this->user->id)->delete();

            DB::commit();
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