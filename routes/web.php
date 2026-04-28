<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{id}', [HomeController::class, 'showProduk'])->name('produk.show');
Route::get('/kategori-list', [HomeController::class, 'kategori'])->name('kategori');
Route::get('/promo', [HomeController::class, 'promo'])->name('promo');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'byCategory'])
    ->name('produk.kategori');


// Route Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/proses-login', [AuthController::class, 'proses_login'])->name('proses.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/proses-register', [AuthController::class, 'proses_register'])->name('proses.register');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'proses_reset_password'])->name('password.update');

// Route untuk cart
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');

// Route Produk
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/stok-produk', [ProdukController::class, 'stock'])->name('produk.stock');
    Route::post('/store-produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/update-produk-{id}', [ProdukController::class, 'update'])
        ->name('produk.update');
    Route::delete('/destroy-produk-{id}', [ProdukController::class, 'destroy'])
        ->name('produk.destroy');
});
Route::get('/produk-showall', [ProdukController::class, 'showall'])->name('produk.showall');

// Route Kategori
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/store-kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/update-kategori-{id}', [KategoriController::class, 'update'])
        ->name('kategori.update');
    Route::delete('/destroy-kategori-{id}', [KategoriController::class, 'destroy'])
        ->name('kategori.destroy');
});

// Route Pesanan
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::put('/update-pesanan-{id}', [PesananController::class, 'update'])
        ->name('pesanan.update');
    Route::delete('/destroy-pesanan-{id}', [PesananController::class, 'destroy'])
        ->name('pesanan.destroy');
    Route::get('/export/excel', [PesananController::class, 'exportExcel'])
        ->name('pesanan.export.excel');
});

// Route Daftar User
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/daftar-user', [UserController::class, 'daftar'])->name('daftar-user.index');
    Route::put('/update-daftar-user-{id}', [UserController::class, 'update'])
        ->name('daftar-user-update.index');
    Route::delete('/destroy-daftar-user-{id}', [UserController::class, 'destroy'])
        ->name('daftar-user.destroy');
    Route::post('/store-user', [UserController::class, 'store'])->name('daftar-user.store');
});

// Route Tentang
use App\Models\Kategori;

Route::get('/tentang-kami', function () {
    return view('pages.tentang', [
        'title' => 'Tentang Kami',
        'categories' => Kategori::latest()->get(),
    ]);
})->name('about');

// Route Admin

Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard');


// Route User
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');
        Route::prefix('akun-saya')->name('account.')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/', [AkunController::class, 'myAccount'])->name('my-account');
            Route::put('/profil', [AkunController::class, 'updateMyAccount'])->name('update-profile');
            Route::put('/password', [AkunController::class, 'updatePassword'])->name('update-password');
            Route::post('/alamat', [AkunController::class, 'updateAddress'])->name('update-address');
            Route::delete('/alamat/{id}', [AkunController::class, 'deleteAddress'])->name('delete-address');
            Route::post('/alamat/{id}/primary', [AkunController::class, 'setPrimaryAddress'])->name('set-primary-address');
            Route::prefix('cart')->name('cart.')->group(function () {
                Route::get('/', [CartController::class, 'index'])->name('index');
                Route::post('/add', [CartController::class, 'add'])->name('add');
                Route::put('/update/{id}', [CartController::class, 'update'])
                    ->name('update');
                Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
                Route::post('/clear', [CartController::class, 'clear'])->name('clear');
            });
            Route::prefix('checkout')->name('checkout.')->group(function () {
                Route::get('/', [CheckoutController::class, 'index'])->name('index');
                Route::get('/continue-payment/{id}', [CheckoutController::class, 'continue'])
                    ->name('continue-payment');
                Route::post('/process', [CheckoutController::class, 'process'])->name('process');
                Route::get('/success', [CheckoutController::class, 'success'])->name('success');
                Route::get('/instructions', [CheckoutController::class, 'instructions'])->name('instructions');
            });
        });
    });
// Routes untuk wilayah
Route::prefix('api')->group(function () {
    Route::get('/provinces', [RegionController::class, 'getProvinces']);
    Route::get('/cities', [RegionController::class, 'getCities']);
    Route::get('/cities/{provinceId}', [RegionController::class, 'getCities']);
    Route::get('/districts', [RegionController::class, 'getDistricts']);
    Route::get('/districts/{cityId}', [RegionController::class, 'getDistricts']);
    Route::get('/regions/search', [RegionController::class, 'search']);
});
