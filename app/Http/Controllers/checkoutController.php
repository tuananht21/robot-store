<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkoutRequest;
use App\Jobs\ProcessCheckout;
use App\Models\Cart;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class checkoutController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm trong giỏ hàng của user hiện tại.
        $cartItems = Cart::where('user_id', Auth::id())->with('detailProduct')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng đang trống.');
        }

        // Tính tổng tiền từ dữ liệu trong database.
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->detailProduct->price;
        });

        return view('pages.checkout', compact('cartItems', 'totalAmount'));
    }

    public function store(checkoutRequest $request)
    {
        $params = $request->validated();

        $cart = Cart::where('user_id', Auth::id())->with('detailProduct')->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Vui lòng thêm sản phẩm vào giỏ hàng.');
        }

        // Tính lại tổng tiền ở server để không tin số tiền từ client gửi lên.
        $totalAmount = $cart->sum(function ($item) {
            return $item->quantity * $item->detailProduct->price;
        });

        $shippingFee = $params['shipping_fee'] ?? 0;
        $totalPayment = $totalAmount + $shippingFee;

        $params['total_amount'] = $totalPayment;
        $params['shipping_fee'] = $shippingFee;

        // COD: Job xử lý tạo Order, DetailOrder và tồn kho.
        if ($params['payment'] === 'cod') {
            ProcessCheckout::dispatch(Auth::user(), $params, null)->onQueue('checkout');

            return redirect()->route('thank-you')->with('success', 'Đặt hàng thành công.');
        }

        // Online: tạo Order trước để lấy order_id gửi sang VNPay.
        if ($params['payment'] === 'online') {
            try {
                $order = DB::transaction(function () use ($params, $cart, $totalPayment, $shippingFee) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
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

                    foreach ($cart as $item) {
                        DetailOrder::create([
                            'order_id' => $order->id,
                            'detail_product_id' => $item->detail_product_id,
                            'quantity' => $item->quantity,
                            'sum_price' => $item->quantity * $item->detailProduct->price,
                        ]);
                    }

                    return $order;
                });

                // Chuyển Order đã tạo sang bước thanh toán VNPay.
                return redirect()->route('checkout.pay-online', ['type' => 'vnpay', 'orderId' => $order->id]);
            } catch (\Throwable $th) {
                report($th);

                return back()->withInput()->with('error', 'Tạo đơn hàng thất bại.');
            }
        }

        return back()->withInput()->with('error', 'Phương thức thanh toán không hợp lệ.');
    }

    public function show($type, $orderID)
    {
        $order = Order::findOrFail($orderID);

        // Không cho user thanh toán đơn hàng không thuộc tài khoản của mình.
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($type !== 'vnpay') {
            return redirect()->route('home')->with('error', 'Phương thức thanh toán không hợp lệ.');
        }

        // Chỉ cho phép thanh toán VNPay với Order Online.
        if ($order->payment_method != 0) {
            return redirect()->route('home')->with('error', 'Đơn hàng không sử dụng thanh toán online.');
        }

        // Không cho thanh toán lại Order đã thanh toán.
        if ($order->payment_status == 1) {
            return redirect()->route('orders')->with('error', 'Đơn hàng này đã được thanh toán.');
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $startTime = date('YmdHis');
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $order->id;
        $vnp_Amount = $order->total_amount;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        // Chuẩn bị dữ liệu gửi sang VNPay.
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

        // Sắp xếp và tạo chuỗi hash theo đúng format VNPay.
        ksort($inputData);
        $hashData = http_build_query($inputData);

        // Tạo chữ ký để VNPay xác thực request.
        $vnpSecureHash = hash_hmac('sha512', $hashData, env('VNPAY_HASH_SECRET'));

        $vnpUrl = env('VNPAY_URL') . '?' . $hashData . '&vnp_SecureHash=' . $vnpSecureHash;

        return redirect()->away($vnpUrl);
    }
}