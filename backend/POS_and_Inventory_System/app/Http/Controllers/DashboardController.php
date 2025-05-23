<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\EstablishmentDetails;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // home
    public function home()
    {
        $salesCount = Checkout::whereDate('created_at', Carbon::today())->sum('total_price');
        $checkoutsCount = Checkout::count();
        $productsCount = Product::count();
        $usersCount = User::count();
        $products = Product::orderBy('created_at', 'desc')->take(5)->get();
        $recentCheckouts = Checkout::with(['product', 'user.userRecord'])->latest()->take(5)->get();

         // Build daily sales data
        $dailyLabels = [];
        $dailySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailyLabels[] = $date->format('Y-m-d');
            $dailySales[] = Checkout::whereDate('created_at', $date)->sum('total_price');
        }

        // Build monthly sales data
        $monthlyLabels = [];
        $monthlySales = [];
        for ($j = 1; $j <= 12; $j++) {
            $monthlyLabels[] = Carbon::create()->month($j)->format('F');
            $monthlySales[] = Checkout::whereMonth('created_at', $j)->whereYear('created_at', now()->year)->sum('total_price');
        }

        return view('dashboard.home', [
            'title' => 'Dashboard',
            'salesCount' => $salesCount,
            'checkoutsCount'=> $checkoutsCount,
            'productsCount'=> $productsCount,
            'usersCount'=> $usersCount,
            'products' => $products,
            'recentCheckouts' => $recentCheckouts,
            'dailyLabels' => $dailyLabels,
            'dailySales' => $dailySales,
            'monthlyLabels' => $monthlyLabels,
            'monthlySales' => $monthlySales,
        ]);
    }

    // attendance
    public function viewAttendance()
    {   
        $attendance = User::orderBy('created_at', 'asc')->get();

        return view('dashboard.attendance', [
            'title' => 'Attendance',
            'attendance' => $attendance,
        ]);
    }

    // details
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
    
    // products
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

    // checkouts
    public function viewCheckouts()
    {
        $checkouts = Checkout::with(['product', 'employee'])
            ->selectRaw('MIN(id) as id')
            ->groupBy('transaction_id')
            ->latest('id')
            ->get()
            ->map(function ($row) {
                return Checkout::with(['product', 'user.userRecord'])->find($row->id);
            });

        return view('dashboard.checkouts', compact('checkouts'), [
            'title' => 'Checkouts',
        ]);
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

    public function getTransactionDetails($transaction_id)
    {
        $checkouts = Checkout::with(['product', 'user.userRecord'])
            ->where('transaction_id', $transaction_id)
            ->get();

        if ($checkouts->isEmpty()) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $userRecord = $checkouts->first()->user->userRecord ?? null;
        $cashier = $userRecord
            ? strtoupper($userRecord->lastname) . ', ' . strtoupper($userRecord->firstname)
            : 'N/A';

        $data = [
            'transaction_id' => $transaction_id,
            'created_at' => $checkouts->first()->created_at
                ->timezone('Asia/Manila')
                ->format('Y-m-d h:i:s A'),
            'cashier' => $cashier,
            'items' => $checkouts->map(function ($checkout) {
                return [
                    'product_name' => $checkout->product->product_name,
                    'quantity' => $checkout->quantity,
                    'total_price' => $checkout->total_price,
                ];
            }),
            'grand_total' => $checkouts->sum('total_price'),
        ];

        return response()->json($data);
    }

    // users
    public function users()
    {
        $users = User::orderBy('created_at', 'asc')->get();

        return view('dashboard.users', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    // sales
    public function sales(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $salesByUser = Checkout::with(['product', 'user.userRecord'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id');

        $totalQuantitySold = Checkout::whereDate('created_at', $date)->sum('quantity');

        return view('dashboard.sales', compact('salesByUser', 'date', 'totalQuantitySold'));
    }

    public function exportSales(Request $request)
    {
        $fileName = now()
            ->timezone('Asia/Manila')
            ->format('Y-m-d h:i:s A') . '-SALES_REPORT.csv';
        $date = $request->input('date', now()->toDateString());

        $salesByUser = Checkout::with(['product', 'user.userRecord'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($salesByUser) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel

            $salesNumber = 0;
            foreach ($salesByUser as $userId => $checkouts) {
                $latestCheckout = $checkouts->sortByDesc('created_at')->first();
                $left = floor($salesNumber / 10000);
                $right = $salesNumber % 10000;
                $salesId = 'SALES-' . str_pad($left, 4, '0', STR_PAD_LEFT) . '-' . str_pad($right, 4, '0', STR_PAD_LEFT);

                $userRecord = $latestCheckout->user->userRecord ?? null;
                $cashier = $userRecord
                    ? strtoupper($userRecord->lastname) . ', ' . strtoupper($userRecord->firstname)
                    : 'N/A';

                // Add column headers before each summary row
                fputcsv($file, ['Date/Time', 'Sales ID', 'Cashier']);

                // Summary row
                fputcsv($file, [
                    $latestCheckout->created_at->timezone('Asia/Manila')->format('d/m/Y h:i A'),
                    $salesId,
                    $cashier,
                ]);
                fputcsv($file, []); // Blank line

                // Group checkouts by transaction_id for this user
                $transactions = $checkouts->groupBy('transaction_id');
                $overallQty = 0;
                $overallPrice = 0;

                foreach ($transactions as $transactionId => $items) {
                    fputcsv($file, ["Checkout ID: $transactionId"]);
                    fputcsv($file, ['Product', 'Qty', 'Price']);

                    $transactionQty = 0;
                    $transactionPrice = 0;

                    foreach ($items as $item) {
                        fputcsv($file, [
                            $item->product->product_name ?? 'N/A',
                            'x' . $item->quantity,
                            '₱' . number_format($item->total_price, 2),
                        ]);
                        $transactionQty += $item->quantity;
                        $transactionPrice += $item->total_price;
                    }

                    fputcsv($file, ['Total Qty:', 'x' . $transactionQty]);
                    fputcsv($file, ['Total Price:', '₱' . number_format($transactionPrice, 2)]);
                    fputcsv($file, []); // Blank line

                    $overallQty += $transactionQty;
                    $overallPrice += $transactionPrice;
                }

                // Overall summary for this employee/day
                fputcsv($file, ['Overall Quantity:', 'x' . $overallQty]);
                fputcsv($file, ['Overall Price:', '₱' . number_format($overallPrice, 2)]);
                fputcsv($file, []); // Blank line between employees

                $salesNumber++;
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
