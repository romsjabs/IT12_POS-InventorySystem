<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSCashierController;
use App\Http\Controllers\POSCustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SignupController;
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
    return redirect('/pos');
});

Route::get('/pos', function () {
    return redirect('/pos/cashier');
})->name('pos');

// auth routes

// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// register
Route::get('/register', [SignupController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [SignupController::class, 'register']);

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware(['auth'])->group(function (){
    // pos routes

    // cashier side
    Route::get('/pos/cashier', [POSCashierController::class, 'index'])->name('pos.cashier');
    Route::get('/pos/cashier/cart', [POSCashierController::class, 'getCart']);
    Route::get('/pos/cashier/transaction-id', [POSCashierController::class, 'getLatestTransactionId']);
    Route::get('/pos/cashier/product/{id}', [POSCashierController::class, 'getProduct'])->name('pos.getProduct');
    Route::post('/pos/cashier/add-to-cart', [POSCashierController::class, 'addToCart'])->name('pos.addToCart');
    Route::post('/pos/cashier/update-cart/{productId}', [POSCashierController::class, 'updateCart'])->name('pos.updateCart');
    Route::delete('/pos/cashier/remove-from-cart/{productId}', [POSCashierController::class, 'removeFromCart'])->name('pos.removeFromCart');
    Route::post('/pos/cashier/checkout', [POSCashierController::class, 'checkout'])->name('pos.checkout');
    Route::post('/pos/cashier/clear-cart', [POSCashierController::class, 'clearCart'])->name('pos.clearCart');
    Route::post('/pos/cashier/reset-discount', [POSCashierController::class, 'resetDiscount'])->name('pos.resetDiscount');
    Route::post('/pos/cashier/set-discount', [POSCashierController::class, 'setDiscount'])->name('pos.setDiscount');
    Route::post('/pos/cashier/discount-state', [POSCashierController::class, 'setDiscountState'])->name('pos.setDiscountState');
    Route::get('/pos/cashier/discount-state', [POSCashierController::class, 'getDiscountState'])->name('pos.getDiscountState');

    // cashier receipt
    Route::get('/pos/cashier/receipt/{transactionId}', [POSCashierController::class, 'showReceipt'])->name('pos.cashier.receipt');

    // customer side
    Route::get('/pos/customer', [POSCustomerController::class, 'index'])->name('pos.customer');

    Route::get('/pos/customer/current-cart', [POSCustomerController::class, 'customerCurrentCart'])->name('pos.customer.currentCart');
    Route::get('/pos/customer/update-product-view', [POSCustomerController::class, 'updateCurrentProduct'])->name('pos.customer.updateProduct');

    Route::get('/pos/customer/current-amount', [POSCustomerController::class, 'currentAmountDetails'])->name('pos.customer.currentAmount');
    Route::get('/pos/customer/change-amount', [POSCustomerController::class, 'currentChangeDetails'])->name('pos.customer.changeAmount');

    Route::post('/pos/customer/reset', [POSCustomerController::class, 'resetCustomerScreen'])->name('pos.customer.reset');


    // dashboard routes
    Route::middleware(['admin'])->group(function () {

        // home
        Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');

        // attendance
        Route::get('/dashboard/attendance', [DashboardController::class, 'viewAttendance'])->name('dashboard.attendance');

        // details
        Route::get('/dashboard/details', [DashboardController::class, 'viewDetails'])->name('dashboard.details');
        Route::post('dashboard/details/store', [DashboardController::class, 'storeDetails'])->name('dashboard.details.store');

        // products
        Route::get('/dashboard/products', [DashboardController::class, 'viewProducts'])->name('dashboard.products');
        Route::post('/dashboard/products/store', [DashboardController::class, 'storeProduct'])->name('dashboard.products.store');
        Route::get('/dashboard/products/{id}/edit', [DashboardController::class, 'editProduct'])->name('dashboard.products.edit');
        Route::put('/dashboard/products/{id}/update', [DashboardController::class, 'updateProduct'])->name('dashboard.products.update');
        Route::delete('/dashboard/products/{id}/delete', [DashboardController::class, 'deleteProduct'])->name('dashboard.products.delete');

        // checkouts
        Route::get('/dashboard/checkouts', [DashboardController::class, 'viewCheckouts'])->name('dashboard.checkouts');
        Route::get('/dashboard/checkouts/transaction/{transaction_id}', [DashboardController::class, 'getTransactionDetails'])->name('dashboard.checkouts.transaction');

        // users
        Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');

        // sales
        Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
        Route::get('/dashboard/sales/export', [DashboardController::class, 'exportSales'])->name('dashboard.sales.export');
    });
    
});

/*

// auth routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

*/

require __DIR__.'/auth.php';
