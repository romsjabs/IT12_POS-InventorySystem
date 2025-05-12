<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSCashierController;
use App\Http\Controllers\POSController;
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

// pos routes
Route::get('/pos/cashier', [POSCashierController::class, 'index'])->name('pos.cashier');
Route::get('/pos/cashier/product/{id}', [POSCashierController::class, 'getProduct'])->name('pos.getProduct');
Route::post('/pos/cashier/add-to-cart', [POSCashierController::class, 'addToCart'])->name('pos.addToCart');
Route::post('/pos/cashier/update-cart/{productId}', [POSCashierController::class, 'updateCart'])->name('pos.updateCart');
Route::delete('/pos/cashier/remove-from-cart/{productId}', [POSCashierController::class, 'removeFromCart'])->name('pos.removeFromCart');
Route::post('/pos/cashier/checkout', [POSCashierController::class, 'checkout'])->name('pos.checkout');
Route::post('/pos/cashier/clear-cart', [POSCashierController::class, 'clearCart'])->name('pos.clearCart');

// dashboard routes
Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');

Route::get('/dashboard/details', [DashboardController::class, 'viewDetails'])->name('dashboard.details');
Route::post('dashboard/details/store', [DashboardController::class, 'storeDetails'])->name('dashboard.details.store');

Route::get('/dashboard/products', [DashboardController::class, 'viewProducts'])->name('dashboard.products');
Route::post('/dashboard/products/store', [DashboardController::class, 'storeProduct'])->name('dashboard.products.store');
Route::get('/dashboard/products/{id}/edit', [DashboardController::class, 'editProduct'])->name('dashboard.products.edit');
Route::put('/dashboard/products/{id}/update', [DashboardController::class, 'updateProduct'])->name('dashboard.products.update');
Route::delete('/dashboard/products/{id}/delete', [DashboardController::class, 'deleteProduct'])->name('dashboard.products.delete');

Route::get('/dashboard/checkouts', [DashboardController::class, 'viewCheckouts'])->name('dashboard.checkouts');

Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');

Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');

// auth routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
