<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    //
    function vnPay(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $paymentData = $request->all();
            // Kiểm tra coi thiếu field nào
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
                return redirect()->route('home')->with('error','Thiếu dữ liệu thanh toán: ' . implode(', ', $missingFields));
            }
            // Kiểm tra thanh toán thành công
            if ($paymentData['vnp_TransactionStatus'] == '00' && $paymentData['vnp_ResponseCode'] == '00') {
                $order = Order::findOrFail($paymentData['vnp_TxnRef']);

                // Kiểm tra Payment đã tồn tại chưa
                $isPayment = Payment::where('order_id', $order->id)->first();

                if (!$isPayment) {
                    $order->payment_status = 1;
                    $order->save();

                    Payment::create([
                        'order_id' => $order->id,
                        'payment_gateway' => 'vnpay',
                        'bank_code' => $paymentData['vnp_BankCode'] ?? null,
                        'response_code' => $paymentData['vnp_ResponseCode'],
                        'transaction_id' => $paymentData['vnp_TransactionNo'] ?? null,
                        'transaction_status' => $paymentData['vnp_TransactionStatus'],
                        'pay_date' => \Carbon\Carbon::createFromFormat('YmdHis', $paymentData['vnp_PayDate']),
                    ]);
                }
            }

            DB::commit();
            return view('pages.pay-online', compact('paymentData'));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Thanh toán thất bại');
        }
    }
}
