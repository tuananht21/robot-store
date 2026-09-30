<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailProduct;
use App\Models\InStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }
        $cartItems = Cart::where('user_id', Auth::user()->id)
            ->with('detailProduct', function ($query) {
                $query->with('product')->with('images', function ($query) {
                    $query->orderByDesc('id');
                });
            })->get();
        return view('pages.cart', compact('cartItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm.');
        }

        $params = $request->except('_token');
        $detailProduct = DetailProduct::findOrFail($params['detail_product_id']);

        $inStock = InStock::where('detail_product_id', $detailProduct->id)->sum('stock');
        $quantity = $params['quantity'] ?? 1;

        $cart = Cart::where('user_id', Auth::user()->id)->where('detail_product_id', $detailProduct->id)->first();

        try {
            //code...
            DB::beginTransaction();
            // Nếu sản phẩm chưa có trong giỏ hàng
            if (!$cart) {
                // Kiểm tra số lượng tồn kho
                if ($quantity > $inStock) {
                    DB::rollBack();
                    return back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
                }

                Cart::create([
                    'user_id' => Auth::user()->id,
                    'detail_product_id' => $params['detail_product_id'],
                    'quantity' => $quantity,
                ]);

                DB::commit();

                return redirect()->route('cart')->with('success', 'Thêm vào giỏ hàng thành công.');
            }

            // Nếu sản phẩm đã có trong giỏ thì tăng số lượng
            if (($cart->quantity + $quantity) > $inStock) {
                DB::rollBack();
                return back()->with('error', 'Đã đạt đến giới hạn trong kho!');
            }

            $cart->quantity += $quantity;
            $cart->save();

            DB::commit();

            return redirect()->route('cart')->with('success', 'Thêm vào giỏ hàng thành công.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Thêm vào giỏ hàng thất bại.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quantity = 0;

        // Tăng hoặc giảm số lượng
        if ($request->input('increase') || $request->input('decrease')) {
            $cart = Cart::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            if ($request->input('increase')) {
                $quantity = $cart->quantity + 1;

                // Kiểm tra số lượng tồn kho
                $inStock = InStock::where('detail_product_id', $cart->detail_product_id)->sum('stock');

                if ($quantity > $inStock) {
                    return back()->with('error', 'Đã đạt đến giới hạn trong kho!');
                }
            } elseif ($request->input('decrease')) {
                $quantity = $cart->quantity - 1;

                if ($quantity <= 0) {
                    return back()->with('error', 'Không thể giảm được nữa!');
                }
            }

            try {
                //code...
                DB::beginTransaction();
                $cart->quantity = $quantity;
                $cart->save();
                DB::commit();
                return back()->with('success', 'Cập nhật giỏ hàng thành công.');
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return back()->with('error', 'Cập nhật giỏ hàng thất bại.');
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        try {
            
            DB::beginTransaction();
            $cart->delete();
            DB::commit();

            return back()->with('success', 'Xóa thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Xóa thất bại.');
        }
    }
}