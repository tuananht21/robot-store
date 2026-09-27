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
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Thanh toán thất bại');
        }
    }
}
