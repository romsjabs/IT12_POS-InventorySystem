<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerScreenState extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_key',
        'amount_given',
        'cart_total',
        'show_change',
    ];
}
