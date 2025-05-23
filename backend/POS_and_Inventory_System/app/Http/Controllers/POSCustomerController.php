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

    // checkouts table
    public function customerCurrentCart()
    {
        $cart = session('customer_cart', []);
        return response()->json($cart);
    }

    // product view
    public function updateCurrentProduct()
    {
        $cart = session('customer_cart', []);
        return response()->json($cart);
    }

    // current amount
    public function currentAmountDetails()
    {
        $cart = session('customer_cart', []);
        $subtotal = 0;
        $discount = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Get discount info from session
        $discountEnabled = session('discount_enabled', false);
        $discountType = session('discount_type', null);

        if ($discountEnabled && in_array($discountType, ['PWD', 'Senior'])) {
            $discount = $subtotal * 0.20;
        }

        $total = $subtotal - $discount;

        return response()->json([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    // change amount
    public function currentChangeDetails()
    {
        $showChange = session('customer_show_change', false);
        $amountGiven = session('customer_amount_given', 0);
        $total = session('customer_cart_total', 0);
        $change = $amountGiven - $total;

        if ($showChange) {
            session(['customer_show_change' => false]);
        }

        return response()->json([
            'show_change' => $showChange,
            'amount_given' => $amountGiven,
            'change' => $change > 0 ? $change : 0,
        ]);
    }

    // reset customer screen
    public function resetCustomerScreen()
    {
        \Session::forget([
            'customer_cart',
            'customer_show_change',
            'customer_amount_given',
            'customer_cart_total'
        ]);

        return response()->json(['success' => true]);
    }

}
