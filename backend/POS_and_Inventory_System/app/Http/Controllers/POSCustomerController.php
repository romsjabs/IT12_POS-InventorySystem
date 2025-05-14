<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSCustomerController extends Controller
{
    public function index()
    {
        return view('pos.customer', [
            'title' => 'POS Customer View',
        ]);
    }

    public function customerCurrentCart()
    {
        $cart = session('customer_cart', []);
        return response()->json($cart);
    }
}
