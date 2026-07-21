<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [AuthController::class, 'login']);
// Dashboard ab PurchaseController ke dashboard function se data uthaye ga
Route::get('/dashboard', [PurchaseController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Auth Middleware ke andar saare IMS Panel ke CRUD routes
Route::middleware('auth')->group(function () {
    
    // 1. Units CRUD
    Route::resource('units', UnitController::class);

    // 2. Suppliers CRUD
    Route::resource('suppliers', SupplierController::class);

    // 3. Products CRUD
    Route::resource('products', ProductController::class);
    
    // 4. Purchases PDF Route (Hamesha resource route se upar honi chahiye)
    Route::get('purchases/{id}/pdf', [PurchaseController::class, 'downloadPdf'])->name('purchases.pdf');
    
    // 5. Purchases CRUD Resource Route
    Route::resource('purchases', PurchaseController::class);

    Route::resource('customers', CustomerController::class);
    // 6. Profile Routes (Breeze default)
Route::middleware(['auth'])->group(function () {
    // ... aapke baqi routes ...
    Route::resource('sales', SaleController::class);
})  

;
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';