<?php

namespace App\Http\Controllers\cart;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\cart\cartValidation;
use App\Models\Cart;
use App\Models\DetailProduct;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    /**
     * Display a listing of user's cart items.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $cartItems = Cart::with(['detailProduct.product'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            return ApiResponse::success($cartItems, 'Get cart items successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get cart items.', 500);
        }
    }

    /**
     * Add product variant to cart or update quantity if already in cart.
     */
    public function store(cartValidation $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $detailProduct = DetailProduct::find($request->detail_product_id);
            if (!$detailProduct) {
                return ApiResponse::error('Detail product not found.', 404);
            }

            $existingItem = Cart::where('user_id', $user->id)
                ->where('detail_product_id', $request->detail_product_id)
                ->first();

            $newQuantity = $request->quantity;
            if ($existingItem) {
                $newQuantity += $existingItem->quantity;
            }

            if ($detailProduct->stock < $newQuantity) {
                return ApiResponse::error('Product stock is insufficient.', 400);
            }

            if ($existingItem) {
                $existingItem->update(['quantity' => $newQuantity]);
                $existingItem->load('detailProduct.product');
                return ApiResponse::success($existingItem, 'Updated cart item quantity successfully.', 200);
            } else {
                $cartItem = Cart::create([
                    'user_id' => $user->id,
                    'detail_product_id' => $request->detail_product_id,
                    'quantity' => $request->quantity,
                ]);
                $cartItem->load('detailProduct.product');
                return ApiResponse::success($cartItem, 'Added to cart successfully.', 201);
            }
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to add to cart.', 500);
        }
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(cartValidation $request, string $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $cartItem = Cart::with('detailProduct')->find($id);

            if (!$cartItem || $cartItem->user_id !== $user->id) {
                return ApiResponse::error('Cart item not found.', 404);
            }

            if ($cartItem->detailProduct->stock < $request->quantity) {
                return ApiResponse::error('Product stock is insufficient.', 400);
            }

            $cartItem->update(['quantity' => $request->quantity]);
            $cartItem->load('detailProduct.product');

            return ApiResponse::success($cartItem, 'Update cart item successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to update cart item.', 500);
        }
    }

    /**
     * Remove an item from cart.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            $cartItem = Cart::find($id);

            if (!$cartItem || $cartItem->user_id !== $user->id) {
                return ApiResponse::error('Cart item not found.', 404);
            }

            $cartItem->delete();

            return ApiResponse::success(null, 'Delete cart item successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to delete cart item.', 500);
        }
    }

    /**
     * Clear all items from user's cart.
     */
    public function clear()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized.', 401);
            }

            Cart::where('user_id', $user->id)->delete();

            return ApiResponse::success(null, 'Cart cleared successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to clear cart.', 500);
        }
    }
}
