<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_sku_id',
        'product_image',
        'product_name',
        'product_category',
        'product_price',
        'product_stock',
    ];
}
