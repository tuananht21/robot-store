<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class categoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->paginate(10);

        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(categoryRequest $request)
    {
        $params = $request->except('_token');
        $categorySlug = Str::slug($params['name']);
        $originalSlug = $categorySlug;
        $count = 1;
        while (Category::where('slug', $categorySlug)->exists()) {
            $categorySlug = $originalSlug . '-' . $count++;
        }

        try {
            DB::beginTransaction();
            Category::create([
                'name' => $params['name'],
                'slug' => $categorySlug
            ]);
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Thêm danh mục thất bại!');
        }
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Danh mục không tồn tại!');
        }
        return view('admin.pages.categories.show', compact('category'));
    }

    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Danh mục không tồn tại!');
        }
        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update(categoryRequest $request, string $slug)
    {
        $params = $request->except('_token', '_method');
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Danh mục không tồn tại!');
        }

        $categorySlug = Str::slug($params['name']);
        $originalSlug = $categorySlug;
        $count = 1;

        while (Category::where('slug', $categorySlug)->where('id', '!=', $category->id)->exists()) {
            $categorySlug = $originalSlug . '-' . $count++;
        }

        try {
            DB::beginTransaction();
            $category->update([
                'name' => $params['name'],
                'slug' => $categorySlug
            ]);
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Cập nhật danh mục thất bại!');
        }
    }

    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return back()->with('error', 'Danh mục không tồn tại!');
        }
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            return back()->with('success', 'Xóa danh mục thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Xóa danh mục thất bại!');
        }
    }
}