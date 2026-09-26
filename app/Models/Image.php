<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = ['path', 'detail_product_id'];

    public function detailProduct(): BelongsTo
    {
        return $this->belongsTo(DetailProduct::class);
    }
}