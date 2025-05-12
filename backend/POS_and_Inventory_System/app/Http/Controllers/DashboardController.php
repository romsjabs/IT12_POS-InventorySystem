<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\EstablishmentDetails;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $salesCount = Checkout::whereDate('created_at', Carbon::today())->sum('total_price');
        $checkoutsCount = Checkout::count();
        $productsCount = Product::count();
        $usersCount = User::count();
        $products = Product::orderBy('created_at', 'desc')->take(5)->get();
        $recentCheckouts = Checkout::with(['product', 'employee'])->latest()->take(5)->get();

        return view('dashboard.home', [
            'title' => 'Dashboard',
            'salesCount' => $salesCount,
            'checkoutsCount'=> $checkoutsCount,
            'productsCount'=> $productsCount,
            'usersCount'=> $usersCount,
            'products' => $products,
            'recentCheckouts' => $recentCheckouts,
        ]);
    }

    public function viewDetails()
    {

        $establishmentDetails = EstablishmentDetails::first();

        return view('dashboard.details', [
            'title' => 'Details',
            'establishmentDetails' => $establishmentDetails
        ]);

    }

    public function storeDetails(Request $request)
    {
        $request->validate([
            'est_name' => 'required',
            'est_address' => 'required',
            'est_contact_number' => 'nullable',
            'est_tin_number' => 'nullable'
        ]);

        $details = EstablishmentDetails::first();

        if ($details) {
            $details->update($request->all());
        } else {
            EstablishmentDetails::create($request->all());
        }

        return redirect()->route('dashboard.details')->with('success', 'Details updated successfully');
    }
    
    public function viewProducts()
    {
        $nextProductId = $this->generateProductId();

        return view('dashboard.products', [
            'title' => 'Products',
            'products' => Product::orderBy('created_at', 'desc')->get(),
            'nextProductId' => $nextProductId,
        ]);
    }

    private function generateProductId()
    {
        $existingIds = Product::pluck('product_id')->filter()->map(function ($id) {
            return (int) str_replace('PRODUCT-', '', $id);
        })->sort()->values();

        $next = 1;

        foreach ($existingIds as $idNum) {
            if ($idNum !== $next) {
                break;
            }
            $next++;
        }
        return 'PRODUCT-' . str_pad($next, 4, '0',  STR_PAD_LEFT);
    }

    public function storeProduct(Request $request)
    {
        $request->merge([
            'product_price' => preg_replace('/[^\d.]/', '', $request->product_price),
        ]);
        
        $validated = $request->validate([
            //'product_id' => 'nullable|string|max:255|unique:products,product_id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        } else {
            $imagePath = 'asets/images/product_image.png';
        }

        $product = new Product();
        $product->product_id = $this->generateProductId();
        $product->product_image = $imagePath;
        $product->product_name = $validated['product_name'];
        $product->product_category = $validated['product_category'];
        $product->product_price = $validated['product_price'];
        $product->product_stock = $validated['product_stock'];
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully!');
        
    }

    public function editProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        return view('dashboard.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::find($id);

        $request->merge([
            'product_price' => preg_replace('/[^\d.]/', '', $request->product_price),
        ]);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        $validatedData = $request->validate([
            'product_id' => 'nullable|string|max:255|unique:products,product_id,' . $id,
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'required|integer|min:0',
        ]);

        unset($validatedData['product_id']);

        $product->update($validatedData);

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
            $product->update(['product_image' => $imagePath]);
        }

        return redirect()->route('dashboard.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        if ($product->product_image && \Storage::disk('public')->exists($product->product_image)) {
            \Storage::disk('public')->delete($product->product_image);
        }

        $product->delete();

        return redirect()->route('dashboard.products')->with('success', 'Product deleted successfully!');
    }

    public function viewCheckouts()
    {
        $checkouts = Checkout::with(['product', 'employee'])
            ->selectRaw('MIN(id) as id')
            ->groupBy('transaction_id')
            ->latest('id')
            ->get()
            ->map(function ($row) {
                return Checkout::with(['product', 'employee'])->find($row->id);
            });

        return view('dashboard.checkouts', compact('checkouts'));
    }

    public function storeCheckouts(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->product_stock < $request->quantity) {
            return redirect()->back()->withErrors(['quanity' => 'Insufficient stock for this product.']);
        }

        $totalPrice = $product->product_price * $request->quantity;

        Checkout::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'user_id' => auth()->id(),
        ]);

        $product->decrement('product_stock', $request->quantity);

        return redirect()->route('dashboard.checkouts')->with('success', 'Checkout created successfully!');
    }

    public function users()
    {
        return view('dashboard.users');
    }

    public function sales()
    {
        return view('dashboard.sales');
    }

}
