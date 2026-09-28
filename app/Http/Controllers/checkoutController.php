<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkoutRequest;
use App\Jobs\ProcessCheckout;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class checkoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::user()->id)
            ->with('detailProduct')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng đang trống.');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->detailProduct->price;
        });

        return view('pages.checkout', compact('cartItems', 'totalAmount'));
    }

    public function store(checkoutRequest $request)
    {
        $params = $request->validated();

        $cart = Cart::where('user_id', Auth::user()->id)
            ->with('detailProduct')
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Vui lòng thêm sản phẩm vào giỏ hàng.');
        }

        $totalAmount = $cart->sum(function ($item) {
            return $item->quantity * $item->detailProduct->price;
        });

        $shippingFee = $params['shipping_fee'] ?? 0;
        $totalPayment = $totalAmount + $shippingFee;

        $params['total_amount'] = $totalPayment;
        $params['shipping_fee'] = $shippingFee;

        if ($params['payment'] === 'cod') {
            try {
                ProcessCheckout::dispatch(Auth::user(), $params, null)->onQueue('checkout');
                return redirect()->route('thank-you')->with('success', 'Đặt hàng thành công.');
            } catch (\Throwable $th) {
                return back()->withInput()->with('error', 'Đặt hàng thất bại.');
            }
        }

        if ($params['payment'] === 'online') {
            try {
                DB::beginTransaction();

                $order = Order::create([
                    'user_id' => Auth::user()->id,
                    'customer_name' => $params['name'],
                    'phone' => $params['phone'],
                    'address' => $params['address'] . ', ' . $params['ward'] . ', ' . $params['provinces'],
                    'note' => $params['note'] ?? null,
                    'total_amount' => $totalPayment,
                    'shipping_fee' => $shippingFee,
                    'payment_method' => false,
                    'payment_status' => false,
                    'status' => 1,
                ]);

                DB::commit();

                return redirect()->route('checkout.pay-online', [
                    'type' => 'vnpay',
                    'orderId' => $order->id,
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();

                return back()->withInput()->with('error', 'Tạo đơn hàng thất bại.');
            }
        }

        return back()->withInput()->with('error', 'Phương thức thanh toán không hợp lệ.');
    }

    public function show($type, $orderID)
    {
        $order = Order::findOrFail($orderID);

        if ($type !== 'vnpay') {
            return redirect()->route('home')->with('error', 'Phương thức thanh toán không hợp lệ.');
        }

        if ($order->payment_method !== false) {
            return redirect()->route('home')->with('error', 'Đơn hàng không sử dụng thanh toán online.');
        }

        if ($order->payment_status) {
            return redirect()->route('orders')->with('error', 'Đơn hàng này đã được thanh toán.');
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $startTime = date('YmdHis');
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $order->id;
        $vnp_Amount = $order->total_amount;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => env('VNPAY_TMN_CODE'),
            'vnp_Amount' => $vnp_Amount * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => $startTime,
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => 'Thanh toan GD:' . $vnp_TxnRef,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => env('VNPAY_RETURN_URL'),
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_ExpireDate' => $expire,
        ];

        ksort($inputData);

        $hashData = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $hashData, env('VNPAY_HASH_SECRET'));

        $vnpUrl = env('VNPAY_URL') . '?' . $hashData . '&vnp_SecureHash=' . $vnpSecureHash;

        return redirect()->away($vnpUrl);
    }

    public function create() {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}