<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\CustomerScreenState;
use App\Models\EstablishmentDetails;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POSCashierController extends Controller
{
    public function index()
    {
        $salesCount = Checkout::whereDate('created_at', Carbon::today())->sum('total_price');
        $checkoutsCount = Checkout::count();
        $categories = Product::select('product_category')
            ->distinct()
            ->get();
        $products = Product::all();
        $usersCount = User::count();

        return view('pos.cashier', [
            'title' => 'POS Cashier View',
            'categories' => $categories,
            'products' => $products,
            'salesCount' => $salesCount,
            'checkoutsCount' => $checkoutsCount,
            'usersCount' => $usersCount,
        ]);
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);
        $result = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $result[] = [
                    'id' => $product->id,
                    'product_id' => $product->product_id,
                    'name' => $product->product_name,
                    'price'=> $product->product_price,
                    'quantity'=> $item['quantity'],
                    'stock' => $product->product_stock,
                ];
            }
        }
        return response()->json($result);
    }
    public function getLatestTransactionId()
    {
        $lastTransaction = Checkout::orderByDesc('transaction_id')->first();

        $transactionId = $lastTransaction ? $lastTransaction->transaction_id : '0000-0000-0001';

        return response()->json([
            'transaction_id' => $transactionId,
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
            'product_id' => $product->product_id,
            'name' => $product->product_name,
            'price' => (float) $product->product_price,
            'stock' => $product->product_stock,
        ]);
    }

    private function generateTransactionId()
    {
        $last = Checkout::orderByDesc('transaction_id')->whereNotNull('transaction_id')->first();

        if (!$last || !$last->transaction_id) {
            return '0000-0000-0001';
        }

        $num = (int)str_replace('-',  '', $last->transaction_id);
        $num++;

        // Always pad to at least 12 digits
        $new = str_pad($num, 12, '0', STR_PAD_LEFT);

        // Split into groups: first group can be longer if number exceeds 12 digits
        $groups = [];
        $remaining = $new;
        $firstGroupLen = strlen($new) - 8;
        $groups[] = substr($remaining, 0, $firstGroupLen);
        $remaining = substr($remaining, $firstGroupLen);
        $groups[] = substr($remaining, 0, 4);
        $groups[] = substr($remaining, 4, 4);

        $transactionId = implode('-', array_filter($groups));

        return $transactionId;

    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cart = Session::get('cart', []);

        if ($request->quantity > $product->product_stock) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cart[$product->id] = [
            'name' => $product->product_name,
            'price' => $product->product_price,
            'quantity' => $request->quantity,
            'stock' => $product->product_stock,
        ];

        Session::put('cart', $cart);
        $this->updateCustomerCartSession();

        return response()->json([
            'message' => 'Product added/updated in cart',
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
        $this->updateCustomerCartSession();

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
        $this->updateCustomerCartSession();

        return response()->json([
            'message' => 'Product removed from cart',
            'cart' => $cart,
        ]);
    }

    public function clearCart()
    {
        Session::forget('cart');
        Session::forget('customer_cart');

        return response()->json(['success' => true]);
    }
    
    public function checkout(Request $request)
    {
        $cash = $request->input('cash');
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty.'], 400);
        }

        $subtotal = 0;
        $transactionId = $this->generateTransactionId();
        $items = [];

        foreach ($cart as $productId => $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $items[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ];

            Checkout::create([
                'transaction_id' => $transactionId,
                'product_id' => $productId,
                'user_id' => auth()->id() ?? null,
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);

            $product = Product::find($productId);
            if ($product) {
                $product->decrement('product_stock', $item['quantity']);
            }
        }

        // --- DISCOUNT LOGIC ---
        $discount = 0;
        $discountEnabled = session('discount_enabled', false);
        $discountType = session('discount_type', null);
        if ($discountEnabled && in_array($discountType, ['PWD', 'Senior'])) {
            $discount = $subtotal * 0.20;
        }
        $total = $subtotal - $discount;
        // ----------------------

        if ($cash < $total) {
            return response()->json(['error' => 'Insufficient cash.'], 400);
        }

        $change = $cash - $total;

        Session::put('customer_amount_given', $cash);
        Session::put('customer_cart_total', $total);
        Session::put('customer_show_change', true);

        Session::forget('cart');
        Session::forget('customer_cart');

        CustomerScreenState::updateOrCreate(
            ['screen_key' => 'main'],
            [
                'amount_given' => $cash,
                'cart_total' => $total,
                'show_change' => true,
            ]
        );

        // --- Fetch establishment details ---
        $est = EstablishmentDetails::first();

        $updatedStocks = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $updatedStocks[$productId] = $product->product_stock;
            }
        }

        return response()->json([
            'success' => true,
            'store_name' => $est->est_name ?? 'My Store',
            'store_address' => $est->est_address ?? '123 Main St.',
            'store_contact' => $est->est_contact_number ?? '',
            'store_tin' => $est->est_tin_number ?? '',
            'date' => now()->format('Y-m-d H:i:s'),
            'transaction_id' => $transactionId,
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'cash' => $cash,
            'change' => $change,
            'updatedStocks' => $updatedStocks,
        ]);
    }

    private function updateCustomerCartSession()
    {
        $cart = Session::get('cart', []);
        $customerCart = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $image = $product->product_image && \Storage::disk('public')
                    ->exists($product->product_image)
                    ? \Storage::url($product->product_image)
                    : asset('storage/defaults/product_image.png');
                $customerCart[] = [
                    'product_id' => $product->product_id,
                    'name' => $product->product_name,
                    'image' => $image,
                    'quantity' => $item['quantity'],
                    'price' => $product->product_price,
                    'category' => $product->product_category,
                ];
            }
        }

        Session::put('customer_cart', $customerCart);
    }

    public function resetDiscount(Request $request)
    {
        Session::forget('discount_type');
        Session::forget('discount_value');
        
        return response()->json([
            'status' => 'reset',
        ]);
    }

    public function setDiscount(Request $request)
    {
        $type = $request->input('type');
        session(['discount_type' => $type]);

        return response()->json([
            'status' => 'set',
            'type' => $type,
        ]);
    }

    public function setDiscountState(Request $request)
    {
        session(['discount_enabled' => $request->input('enabled', false)]);
        session(['discount_type' => $request->input('type', null)]);
        return response()->json(['status' => 'ok']);
    }

    public function getDiscountState()
    {
        return response()->json([
            'enabled' => session('discount_enabled', false),
            'type' => session('discount_type', null)
        ]);
    }

    // receipt printing
    /*
    public function showReceipt($transactionId)
    {
        $est = EstablishmentDetails::first();

        $checkoutItems = Checkout::where('transaction_id', $transactionId)->get();
        $items = [];
        $subtotal = 0;

        foreach ($checkoutItems as $item) {
            $items[] = [
                'name' => $item->product->product_name,
                'quantity' => $item->quantity,
                'total' => $item->total_price,
            ];
            $subtotal += $item->total_price;
        }

        $discount = 0;
        $total = $subtotal - $discount;
        $cash = $total;
        $change = 0;

        return view('pos.receipt',  [
            'store_name' => $est->est_name ?? 'My Store',
            'store_address' => $est->est_address ?? '123 Main St.',
            'store_contact' => $est->est_contact_number ?? '',
            'store_tin' => $est->est_tin_number ?? '',
            'date' => now(),
            'transaction_id' => $transactionId,
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'cash' => $cash,
            'change' => $change,
        ]);
    }
    */
    
}
