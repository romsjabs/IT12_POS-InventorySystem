<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');
Route::get('/dashboard/details', [DashboardController::class, 'details'])->name('dashboard.details');
Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products');
Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
Route::get('/dashboard/checkouts', [DashboardController::class, 'checkouts'])->name('dashboard.checkouts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
