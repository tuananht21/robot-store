<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class productController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'detailProducts'])->orderByDesc('id');
        $categories = Category::all();
        $search = null;

        if ($request->isMethod('POST')) {
            $search = $request->input('search');
            if ($search) {
                $products->where('name', 'like', '%' . $search . '%');
            }
        }

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $products->where('status', $request->input('status'));
        }

        $products = $products->paginate(10)->appends($request->query());

        return view('admin.pages.products.index', compact('products', 'categories', 'search'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.pages.products.create', compact('categories'));
    }

    public function store(productRequest $request)
    {
        $params = $request->validated();
        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            if (!$request->file('thumbnail')->isValid()) {
                return back()->withInput()->with('error', 'Ảnh không hợp lệ!');
            }

            $slug = Str::slug($params['name']);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $extension;
            $thumbnail = $request->file('thumbnail')->storeAs('uploads/products', $filename, 'public');
        }

        $slug = Str::slug($params['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        try {
            DB::beginTransaction();

            Product::create([
                'name' => $params['name'],
                'description' => $params['description'] ?? null,
                'thumbnail' => $thumbnail,
                'status' => $params['status'] ?? true,
                'slug' => $slug,
                'category_id' => $params['category_id'] ?? null
            ]);

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($thumbnail && Storage::disk('public')->exists($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }

            return back()->withInput()->with('error', 'Thêm sản phẩm thất bại!');
        }
    }

    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'detailProducts.images',
            'detailProducts.specifications',
            'detailProducts.inStock'
        ])->where('slug', $slug)->first();

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        return view('admin.pages.products.show', compact('product'));
    }

    public function edit(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();
        $categories = Category::all();

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        return view('admin.pages.products.edit', compact('product', 'categories'));
    }

    public function update(productRequest $request, string $slug)
    {
        $params = $request->validated();
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        $oldThumbnail = $product->thumbnail;
        $thumbnail = $product->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if (!$request->file('thumbnail')->isValid()) {
                return back()->withInput()->with('error', 'Ảnh không hợp lệ!');
            }

            $newSlug = Str::slug($params['name']);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filename = $newSlug . '-' . time() . '.' . $extension;
            $thumbnail = $request->file('thumbnail')->storeAs('uploads/products', $filename, 'public');
        }

        $newSlug = Str::slug($params['name']);
        $originalSlug = $newSlug;
        $count = 1;

        while (Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
            $newSlug = $originalSlug . '-' . $count++;
        }

        try {
            DB::beginTransaction();

            $product->update([
                'name' => $params['name'],
                'description' => $params['description'] ?? null,
                'thumbnail' => $thumbnail,
                'status' => $params['status'] ?? true,
                'slug' => $newSlug,
                'category_id' => $params['category_id'] ?? null
            ]);

            DB::commit();

            if ($request->hasFile('thumbnail') && $oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($request->hasFile('thumbnail') && $thumbnail && Storage::disk('public')->exists($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }

            return back()->withInput()->with('error', 'Cập nhật sản phẩm thất bại!');
        }
    }

    public function destroy(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại!');
        }

        $thumbnail = $product->thumbnail;

        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();

            if ($thumbnail && Storage::disk('public')->exists($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }

            return back()->with('success', 'Xóa sản phẩm thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Xóa sản phẩm thất bại!');
        }
    }
}