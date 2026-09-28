<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCheckout;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    public function vnPay(Request $request)
    {
        try {

            DB::beginTransaction();
            $paymentData = $request->all();
            $requiredFields = [
                'vnp_TxnRef',
                'vnp_TransactionNo',
                'vnp_TransactionStatus',
                'vnp_ResponseCode',
                'vnp_Amount',
                'vnp_PayDate',
                'vnp_SecureHash',
            ];

            $missingFields = array_filter($requiredFields, function ($field) use ($paymentData) {
                return !isset($paymentData[$field]) || $paymentData[$field] === '';
            });

            if (!empty($missingFields)) {
                DB::rollBack();

                return redirect()->route('home')->with('error', 'Thiếu dữ liệu thanh toán: ' . implode(', ', $missingFields));
            }

            $order = Order::findOrFail($paymentData['vnp_TxnRef']);

            if ($order->payment_method !== false) {
                DB::rollBack();

                return redirect()->route('home')->with('error', 'Đơn hàng không sử dụng thanh toán online.');
            }

            if ($paymentData['vnp_TransactionStatus'] == '00' && $paymentData['vnp_ResponseCode'] == '00') {
                $isPayment = Payment::where('order_id', $order->id)->first();

                if (!$isPayment) {
                    $cart = Cart::where('user_id', $order->user_id)->with('detailProduct')->get();

                    if ($cart->isEmpty()) {
                        DB::rollBack();
                        return redirect()->route('home')->with('error', 'Giỏ hàng không còn sản phẩm để xử lý đơn hàng.');
                    }

                    $order->payment_status = true;
                    $order->save();

                    Payment::create([
                        'order_id' => $order->id,
                        'payment_gateway' => 'vnpay',
                        'bank_code' => $paymentData['vnp_BankCode'] ?? null,
                        'response_code' => $paymentData['vnp_ResponseCode'],
                        'transaction_id' => $paymentData['vnp_TransactionNo'],
                        'transaction_status' => $paymentData['vnp_TransactionStatus'],
                        'pay_date' => \Carbon\Carbon::createFromFormat('YmdHis', $paymentData['vnp_PayDate']),
                    ]);

                    DB::commit();
                    ProcessCheckout::dispatch($order->user, [], $order->id)->onQueue('checkout');
                    return view('pages.pay-online', compact('paymentData'));
                }
            }

            DB::commit();
            return view('pages.pay-online', compact('paymentData'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Thanh toán thất bại.');
        }
    }
}