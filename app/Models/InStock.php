<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InStock extends Model
{
    protected $fillable = ['detail_product_id', 'stock'];

    public function detailProduct(): BelongsTo
    {
        return $this->belongsTo(DetailProduct::class);
    }
}