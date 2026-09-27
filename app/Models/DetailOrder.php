<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailOrder extends Model
{
    protected $fillable = ['order_id', 'detail_product_id', 'quantity', 'sum_price'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function detailProduct(): BelongsTo
    {
        return $this->belongsTo(DetailProduct::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}