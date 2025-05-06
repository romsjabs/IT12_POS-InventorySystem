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

        return view('dashboard.home', [
            'title' => 'Dashboard',
            'salesCount' => $salesCount,
            'checkoutsCount'=> $checkoutsCount,
            'productsCount'=> $productsCount,
            'usersCount'=> $usersCount
        ]);
    }

    public function details()
    {

        $establishmentDetails = EstablishmentDetails::first();

        return view('dashboard.details', [
            'title' => 'Details',
            'establishmentDetails' => $establishmentDetails
        ]);

    }

    public function updateDetails(Request $request)
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
    
    public function products()
    {
        return view('dashboard.products', [
            'title' => 'Products',
            'products' => Products::all()
        ]);
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
