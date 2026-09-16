<?php

namespace App\Http\Controllers\category;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\category\categoryValidation;
use App\Models\Category;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            //code...
            $categories = Category::all();
            return ApiResponse::success($categories, 'Get categories successfully.', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Failed to get categories.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(categoryValidation $categoryValidation)
    {
        //
        try {
            //code...
            $name = $categoryValidation->name;
            $slug = $categoryValidation->slug;

            $category = Category::create([
                'name' => $name,
                'slug' => $slug,
            ]);

            return ApiResponse::success($category, 'Create category successfully.', 201);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Failed to create category.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            //code...
            $category = Category::find($id);

            if (!$category) {
                return ApiResponse::error('Category not found.', 404);
            }

            return ApiResponse::success($category, 'Get category successfully.', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Failed to get category.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(categoryValidation $categoryValidation, string $id)
    {
        //
        try {
            $category = Category::find($id);
            if (!$category) {
                return ApiResponse::error('Category not found.', 404);
            }
            $category->update($categoryValidation->validated());
            return ApiResponse::success($category, 'Update category successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to update category.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return ApiResponse::error('Category not found.', 404);
            }

            // Kiểm tra xem danh mục có sản phẩm không
            if ($category->products()->count() > 0) {
                return ApiResponse::error('Cannot delete category that has products.', 400);
            }

            $category->delete();

            return ApiResponse::success(null, 'Delete category successfully.', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Failed to delete category.', 500);
        }
    }
}
