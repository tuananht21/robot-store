<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inStockController extends Controller
{
    public function index($detailID)
    {
        $inStock = InStock::where('detail_product_id', $detailID)->first();

        return view('admin.pages.inStock.index', compact('detailID', 'inStock'));
    }

    public function create()
    {
        //
    }

    public function store()
    {
        
    }

    public function show(string $id)
    {
        //
    }

    public function edit()
    {
        
    }

    public function update(Request $request, string $detailID)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $inStock = InStock::where('detail_product_id', $detailID)->first();

            if ($inStock) {
                $inStock->update([
                    'stock' => $request->stock,
                ]);
            } else {
                InStock::create([
                    'detail_product_id' => $detailID,
                    'stock' => $request->stock,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.detail-products.in-stock.index', $detailID)->with('success', 'Cập nhật tồn kho thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Cập nhật tồn kho thất bại!');
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
