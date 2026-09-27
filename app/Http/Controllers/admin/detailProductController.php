<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\detailProductRequest;
use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class detailProductController extends Controller
{
    public function index(Product $product)
    {
        $detailProducts = $product->detailProducts()
            ->with(['images', 'specifications', 'inStock'])
            ->latest()
            ->paginate(10);

        return view('admin.detailProduct.index', compact('product', 'detailProducts'));
    }

    public function create(Product $product)
    {
        return view('admin.detailProduct.create', compact('product'));
    }

    public function store(detailProductRequest $request, Product $product)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $product->detailProducts()->create($data);

            DB::commit();

            return redirect()->route('admin.products.detail-products.index', $product)->with('success', 'Thêm detail product thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Thêm detail product thất bại!');
        }
    }

    public function edit(Product $product, DetailProduct $detailProduct)
    {
        $this->checkProduct($product, $detailProduct);

        return view('admin.detailProduct.edit', compact('product', 'detailProduct'));
    }

    public function update(detailProductRequest $request, Product $product, DetailProduct $detailProduct)
    {
        $this->checkProduct($product, $detailProduct);

        try {
            DB::beginTransaction();

            $detailProduct->update($request->validated());

            DB::commit();

            return redirect()->route('admin.products.detail-products.index', $product)->with('success', 'Cập nhật detail product thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Cập nhật detail product thất bại!');
        }
    }

    public function destroy(Product $product, DetailProduct $detailProduct)
    {
        $this->checkProduct($product, $detailProduct);

        if ($detailProduct->detailOrders()->exists()) {
            return back()->with('error', 'Không thể xóa detail product đã có đơn hàng!');
        }

        try {
            DB::beginTransaction();

            $detailProduct->images()->delete();
            $detailProduct->specifications()->delete();
            $detailProduct->inStock()->delete();
            $detailProduct->carts()->delete();
            $detailProduct->delete();

            DB::commit();

            return redirect()->route('admin.products.detail-products.index', $product)->with('success', 'Xóa detail product thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Xóa detail product thất bại!');
        }
    }

    private function checkProduct(Product $product, DetailProduct $detailProduct)
    {
        if ($detailProduct->product_id !== $product->id) {
            abort(404);
        }
    }
}