<?php

namespace App\Http\Controllers\image;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\image\imageValidation;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class imageController extends Controller
{
    /**
     * Display a listing of images.
     */
    public function index()
    {
        try {
            $images = Image::with('product')->latest()->get();
            return ApiResponse::success($images, 'Get images successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get images.', 500);
        }
    }

    /**
     * Display images of a specific product.
     */
    public function getByProduct(string $productId)
    {
        try {
            $images = Image::where('product_id', $productId)->get();
            return ApiResponse::success($images, 'Get images by product successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get images.', 500);
        }
    }

    /**
     * Store a newly created image.
     */
    public function store(imageValidation $request)
    {
        try {
            $imagePath = '';

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $storedPath = $file->store('products', 'public');
                $imagePath = 'storage/' . $storedPath;
            } else {
                $imagePath = $request->path;
            }

            $image = Image::create([
                'product_id' => $request->product_id,
                'path' => $imagePath,
            ]);

            $image->load('product');

            return ApiResponse::success($image, 'Create image successfully.', 201);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to create image.', 500);
        }
    }

    /**
     * Display the specified image.
     */
    public function show(string $id)
    {
        try {
            $image = Image::with('product')->find($id);

            if (!$image) {
                return ApiResponse::error('Image not found.', 404);
            }

            return ApiResponse::success($image, 'Get image successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to get image.', 500);
        }
    }

    /**
     * Remove the specified image.
     */
    public function destroy(string $id)
    {
        try {
            $image = Image::find($id);

            if (!$image) {
                return ApiResponse::error('Image not found.', 404);
            }

            // Remove file from storage if stored locally under storage/
            if (str_starts_with($image->path, 'storage/')) {
                $relativePath = str_replace('storage/', '', $image->path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            $image->delete();

            return ApiResponse::success(null, 'Delete image successfully.', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Failed to delete image.', 500);
        }
    }
}
