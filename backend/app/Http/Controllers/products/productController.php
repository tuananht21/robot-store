<?php

namespace App\Http\Controllers\products;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\products\productValidation;
use App\Models\Product;

class productController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        try {
            $products = Product::with(['category', 'detailProducts', 'images'])->latest()->get();
            return ApiResponse::success($products, 'Get products successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get products.', 500);
        }
    }

    /**
     * Store a newly created product.
     */
    public function store(productValidation $productValidation)
    {
        try {
            $name = $productValidation->name;
            $description = $productValidation->description;
            $thumbnail = $productValidation->thumbnail;
            $status = $productValidation->status;
            $slug = $productValidation->slug;
            $category_id = $productValidation->category_id;

            $product = Product::create([
                'name' => $name,
                'description' => $description,
                'thumbnail' => $thumbnail,
                'status' => $status,
                'slug' => $slug,
                'category_id' => $category_id,
            ]);

            $product->load(['category', 'detailProducts', 'images']);

            return ApiResponse::success($product, 'Create product successfully.', 201);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to create product.', 500);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with(['category', 'detailProducts', 'images'])
                ->find($id);

            if (!$product) {
                return ApiResponse::error('Product not found.', 404);
            }

            return ApiResponse::success($product, 'Get product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get product.', 500);
        }
    }

    /**
     * Update the specified product.
     */
    public function update(productValidation $productValidation, string $id) 
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return ApiResponse::error('Product not found.', 404);
            }

            $name = $productValidation->name;
            $description = $productValidation->description;
            $thumbnail = $productValidation->thumbnail;
            $status = $productValidation->status;
            $slug = $productValidation->slug;
            $category_id = $productValidation->category_id;

            $product->update([
                'name' => $name,
                'description' => $description,
                'thumbnail' => $thumbnail,
                'status' => $status,
                'slug' => $slug,
                'category_id' => $category_id,
            ]);

            $product->load(['category', 'detailProducts', 'images']);
            return ApiResponse::success($product, 'Update product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to update product.',500);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return ApiResponse::error('Product not found.',404);
            }
            
            $product->delete();
            return ApiResponse::success(null,'Delete product successfully.',200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to delete product.',500);
        }
    }
}
