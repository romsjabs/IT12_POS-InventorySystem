<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function details()
    {
        return view('dashboard.details');
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
