<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Umkm\DashboardController as UmkmDashboardController;
use App\Http\Controllers\Umkm\ProfileController as UmkmProfileController;
use App\Http\Controllers\Umkm\ProductController as UmkmProductController;
use App\Http\Controllers\Umkm\ReviewController as UmkmReviewController;
use App\Http\Controllers\Umkm\ReportController as UmkmReportController;
use App\Http\Controllers\Customer\HomeController as CustHomeController;
use App\Http\Controllers\Customer\ProductController as CustProductController;
use App\Http\Controllers\Customer\StoreController as CustStoreController;
use App\Http\Controllers\Customer\OrderController as CustOrderController;

// Public Customer Pages
Route::get('/', [CustHomeController::class, 'index'])->name('home');
Route::get('/produk', [CustProductController::class, 'index'])->name('produk.index');
Route::get('/umkm', [CustHomeController::class, 'umkmList'])->name('umkm.list');
Route::get('/toko/{id}', [CustStoreController::class, 'show'])->name('toko.show');
Route::get('/produk/{id}', [CustProductController::class, 'show'])->name('produk.show');

Route::view('/tentang', 'customer.about')->name('about');
Route::view('/ulasan/{id}', 'customer.ulasan-form')->name('ulasan.create');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::view('/register', 'auth.register-customer')->name('register');
Route::post('/register', [AuthController::class, 'registerCustomer']);

Route::get('/register-umkm', function () {
    return view('auth.register-umkm');
})->name('register.umkm');
Route::post('/register-umkm', [AuthController::class, 'registerUmkm']);

Route::view('/lupa-password', 'auth.lupa-password')->name('password.request');

// Authenticated Route Protections
Route::middleware(['auth'])->group(function () {

    // Customer Group
    Route::middleware(['role:customer'])->group(function () {
        Route::get('/pesan/{id}', [CustOrderController::class, 'create'])->name('pesanan.create');
        Route::post('/pesan/{id}', [CustOrderController::class, 'store'])->name('pesanan.store');
        Route::get('/pesanan-saya', [CustOrderController::class, 'riwayat'])->name('pesanan.riwayat');
        Route::post('/pesanan/{id}/terima', [CustOrderController::class, 'receive'])->name('pesanan.terima');
    });

    // Admin Group
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // UMKM management
        Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('umkm.index');
        Route::get('/umkm/{id}/verifikasi', [AdminUmkmController::class, 'show'])->name('umkm.verifikasi');
        Route::post('/umkm/{id}/verify', [AdminUmkmController::class, 'verify'])->name('umkm.verify');
        
        // Categories CRUD
        Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('kategori');
        Route::post('/kategori', [AdminCategoryController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{category}', [AdminCategoryController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{category}', [AdminCategoryController::class, 'destroy'])->name('kategori.destroy');
        
        // Reports
        Route::get('/laporan', [AdminReportController::class, 'index'])->name('laporan');
    });

    // UMKM Group
    Route::middleware(['role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/dashboard', [UmkmDashboardController::class, 'index'])->name('dashboard');
        
        // Store Profile
        Route::get('/profil', [UmkmProfileController::class, 'index'])->name('profil');
        Route::post('/profil', [UmkmProfileController::class, 'update']);
        
        // Products Catalog
        Route::get('/produk', [UmkmProductController::class, 'index'])->name('produk.index');
        Route::get('/produk/tambah', [UmkmProductController::class, 'create'])->name('produk.create');
        Route::post('/produk', [UmkmProductController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}/edit', [UmkmProductController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [UmkmProductController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [UmkmProductController::class, 'destroy'])->name('produk.destroy');
        
        // Reviews
        Route::get('/ulasan', [UmkmReviewController::class, 'index'])->name('ulasan');
        
        // Reports
        Route::get('/laporan', [UmkmReportController::class, 'index'])->name('laporan');
    });
});
