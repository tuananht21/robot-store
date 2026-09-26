<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class pageController extends Controller
{
    public function home()
    {
        $categories = Category::withCount('products')->get();

        $products = Product::with(['category', 'detailProducts'])->where('status', true)->latest()->take(8)->get();

        return view('pages.home', compact('categories', 'products'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function product(Request $request)
    {
        $categories = Category::withCount('products')->get();
        
        $products = Product::with(['category', 'detailProducts'])->where('status', true);

        if ($request->filled('category')) {
            $products->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->latest()->paginate(12)->withQueryString();

        return view('pages.product', compact('categories', 'products'));
    }

    public function detail(string $slug)
    {
        $product = Product::with([
            'category',
            'detailProducts.images',
            'detailProducts.specifications',
            'detailProducts.inStock'
        ])->where('slug', $slug)->where('status', true)->first();

        if (!$product) {
            return view('pages.notFound');
        }

        $relatedProducts = Product::with(['category', 'detailProducts'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->where('status', true)->latest()->take(4)->get();
        return view('pages.show', compact('product', 'relatedProducts'));
    }
}
