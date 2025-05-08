<?php

namespace App\Http\Controllers;

use App\Models\Checkouts;
use App\Models\EstablishmentDetails;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $salesCount = Checkouts::whereDate('created_at', Carbon::today())->sum('total_price');
        $checkoutsCount = Checkouts::count();
        $productsCount = Products::count();
        $usersCount = Users::count();
        $products = Products::all();

        return view('dashboard.home', [
            'title' => 'Dashboard',
            'salesCount' => $salesCount,
            'checkoutsCount'=> $checkoutsCount,
            'productsCount'=> $productsCount,
            'usersCount'=> $usersCount,
            'products' => $products
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
        return view('dashboard.products', [
            'title' => 'Products',
            'products' => Products::all()
        ]);
    }

    public function storeProduct(Request $request)
    {
        $request->merge([
            'product_price' => preg_replace('/[^\d.]/', '', $request->product_price),
        ]);
        
        $validated = $request->validate([
            'product_sku_id' => 'nullable|string|max:255|unique:products,product_sku_id',
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

        $product = new Products();
        $product->product_sku_id = $validated['product_sku_id'];
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
        $product = Products::find($id);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        return view('dashboard.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id) {
        $product = Products::find($id);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        $validatedData = $request->validate([
            'product_sku_id' => 'nullable|unique:products,product_sku_id|string|max:255',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'required|integer|min:0',
        ]);

        $product->update($validatedData);

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
            $product->update(['product_image' => $imagePath]);
        }

        return redirect()->route('dashboard.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return redirect()->route('dashboard.products')->with('error', 'Product not found.');
        }

        if ($product->product_image && \Storage::disk('public')->exists($product->product_image)) {
            \Storage::disk('public')->delete($product->product_image);
        }

        $product->delete();

        return redirect()->route('dashboard.products')->with('success', 'Product deleted successfully!');
    }

    public function users()
    {
        return view('dashboard.users');
    }

    public function sales()
    {
        return view('dashboard.sales');
    }

    public function checkouts()
    {
        return view('dashboard.checkouts');
    }
}
