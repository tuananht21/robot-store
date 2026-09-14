<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    //
    use HasFactory;
    protected $table = 'detail_orders';
    protected $fillable = ['order_id', 'detail_product_id', 'quantity', 'price'];

    // Thuộc về đơn hàng nào
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Liên kết tới phiên bản cấu hình được chọn mua
    public function detailProduct()
    {
        return $this->belongsTo(DetailProduct::class, 'detail_product_id');
    }
}
