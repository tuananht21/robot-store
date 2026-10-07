<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCheckout;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    public function vnPay(Request $request)
    {
        try {

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

            foreach ($requiredFields as $field) {
                if (!isset($paymentData[$field]) || $paymentData[$field] === '') {
                    return redirect()->route('home')->with('error', 'Thiếu dữ liệu thanh toán.');
                }
            }

            // Kiểm tra chữ ký VNPay.
            $secureHash = $paymentData['vnp_SecureHash'];
            unset($paymentData['vnp_SecureHash'], $paymentData['vnp_SecureHashType']);

            ksort($paymentData);
            $checkHash = hash_hmac('sha512',http_build_query($paymentData),env('VNPAY_HASH_SECRET'));

            if (!hash_equals($checkHash, $secureHash)) {
                return redirect()->route('home')->with('error', 'Chữ ký thanh toán không hợp lệ.');
            }

            $order = Order::find($paymentData['vnp_TxnRef']);

            if (!$order) {
                return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
            }

            // Chỉ xử lý đơn hàng thanh toán bằng VNPay.
            if ($order->payment_method != 0) {
                return redirect()->route('home')->with('error', 'Đơn hàng không sử dụng thanh toán online.');
            }

            // VNPay gửi số tiền theo đơn vị VND x 100.
            if ($order->total_amount * 100 != $paymentData['vnp_Amount']) {
                return redirect()->route('home')->with('error', 'Số tiền thanh toán không hợp lệ.');
            }

            // Chỉ xử lý khi giao dịch thành công.
            $isSuccess = $paymentData['vnp_TransactionStatus'] === '00'
                && $paymentData['vnp_ResponseCode'] === '00';

            if ($isSuccess) {
                $paymentCreated = DB::transaction(function () use ($order, $paymentData) {
                    // Tránh tạo Payment trùng khi VNPay callback nhiều lần.
                    if (Payment::where('order_id', $order->id)->exists()) {
                        return false;
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
                        'pay_date' => Carbon::createFromFormat('YmdHis', $paymentData['vnp_PayDate']),
                    ]);

                    return true;
                });

                if ($paymentCreated) {
                    ProcessCheckout::dispatch($order->user, [], $order->id)->onQueue('checkout');
                }
            }

            return view('pages.pay-online', compact('paymentData'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->route('home')->with('error', 'Thanh toán thất bại.');
        }
    }
}