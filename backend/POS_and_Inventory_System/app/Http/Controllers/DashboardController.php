<?php

namespace App\Http\Controllers;

use App\Models\Checkouts;
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
        return view('dashboard.details', ['title'=> 'Details']);
    }
    
    public function products()
    {
        return view('dashboard.products');
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
