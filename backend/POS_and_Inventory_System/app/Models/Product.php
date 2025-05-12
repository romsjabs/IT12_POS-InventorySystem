<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_image',
        'product_name',
        'product_category',
        'product_price',
        'product_stock',
    ];

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }
}
