<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POSCashierController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('pos.cashier', [
            'title' => 'POS Cashier View',
            'products' => $products,
        ]);
    }
    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'sku' => $product->product_sku_id,
            'name' => $product->product_name,
            'price' => (float) $product->product_price,
            'stock' => $product->product_stock,
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] + $request->quantity > $product->product_stock) {
                return response()->json(['error' => 'Not enough stock available'], 400);
            }
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            if ($request->quantity > $product->product_stock) {
                return response()->json(['error' => 'Insufficient stock'], 400);
            }
            $cart[$product->id] = [
                'name' => $product->product_name,
                'price' => $product->product_price,
                'quantity' => $request->quantity,
                'stock' => $product->product_stock,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $cart,
        ]);
    }

    public function updateCart(Request $request, $productId)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['error' => 'Product not found in cart'], 404);
        }

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $newQuantity = $request->quantity;

        if ($newQuantity < 1 || $newQuantity > $product->product_stock) {
            return response()->json(['error' => 'Invalid quantity'], 400);
        }

        $cart[$productId]['quantity'] = $newQuantity;

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Cart updated successfully',
            'cart' => $cart,
        ]);
    }

    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['error' => 'Product not found in cart'], 404);
        }

        unset($cart[$productId]);

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Product removed from cart',
            'cart' => $cart,
        ]);
    }
    
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty.'], 400);
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $cash = $request->cash;

        if ($cash < $total) {
            return response()->json(['error' => 'Insufficient cash.'], 400);
        }

        $change = $cash - $total;

        Session::forget('cart');

        return response()->json(['success' => 'Checkout successful!', 'total' => $total, 'change' => $change]);
    }
}
