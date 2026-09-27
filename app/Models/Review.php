<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['detail_order_id', 'detail_product_id', 'rating', 'content'];

    public function detailOrder(): BelongsTo
    {
        return $this->belongsTo(DetailOrder::class);
    }

    public function detailProduct(): BelongsTo
    {
        return $this->belongsTo(DetailProduct::class);
    }
}