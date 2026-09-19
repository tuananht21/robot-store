<?php

namespace App\Http\Controllers\detailProduct;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\detailProduct\detailProductValidation;
use App\Models\DetailProduct;

class detailProductController extends Controller
{
    /**
     * Display a listing of detail products.
     */
    public function index()
    {
        try {
            $details = DetailProduct::with('product')->latest()->get();
            return ApiResponse::success($details, 'Get detail products successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get detail products.', 500);
        }
    }

    /**
     * Display detail products of a specific product.
     */
    public function getByProduct(string $productId)
    {
        try {
            $details = DetailProduct::where('product_id', $productId)->get();
            return ApiResponse::success($details, 'Get detail products by product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get detail products.', 500);
        }
    }

    /**
     * Store a newly created detail product.
     */
    public function store(detailProductValidation $request)
    {
        try {
            $detailProduct = DetailProduct::create([
                'product_id' => $request->product_id,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'version' => $request->version,
                'stock' => $request->stock,
            ]);

            $detailProduct->load('product');

            return ApiResponse::success($detailProduct, 'Create detail product successfully.', 201);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to create detail product.', 500);
        }
    }

    /**
     * Display the specified detail product.
     */
    public function show(string $id)
    {
        try {
            $detailProduct = DetailProduct::with('product')->find($id);

            if (!$detailProduct) {
                return ApiResponse::error('Detail product not found.', 404);
            }

            return ApiResponse::success($detailProduct, 'Get detail product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get detail product.', 500);
        }
    }

    /**
     * Update the specified detail product.
     */
    public function update(detailProductValidation $request, string $id)
    {
        try {
            $detailProduct = DetailProduct::find($id);

            if (!$detailProduct) {
                return ApiResponse::error('Detail product not found.', 404);
            }

            $detailProduct->update([
                'product_id' => $request->product_id,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'version' => $request->version,
                'stock' => $request->stock,
            ]);

            $detailProduct->load('product');

            return ApiResponse::success($detailProduct, 'Update detail product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to update detail product.', 500);
        }
    }

    /**
     * Remove the specified detail product.
     */
    public function destroy(string $id)
    {
        try {
            $detailProduct = DetailProduct::find($id);

            if (!$detailProduct) {
                return ApiResponse::error('Detail product not found.', 404);
            }

            $detailProduct->delete();

            return ApiResponse::success(null, 'Delete detail product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to delete detail product.', 500);
        }
    }
}
