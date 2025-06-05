<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManajerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\LogUserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use Laravel\Prompts\Themes\Default\ConfirmPromptRenderer;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/barang-keluar-page', [BarangKeluarController::class, 'show'])->name('barang.out');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::post('/barang-masuk', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/fotos', [FotoController::class, 'index'])->name('fotos.index');
    Route::get('/barang/cari', [BarangController::class, 'search'])->name('barang.search');
    Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
    Route::delete('/item/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/index-admin', [AdminController::class, 'show'])->name('index');
    Route::get('/barang', [AdminController::class, 'filter'])->name('barang.index');
    Route::get('/manajer/index/{id?}', [ManajerController::class, 'index'])->name('manajer.dashboard');
    Route::post('/users', [UserController::class, 'store'])->name('users');
    Route::get('/api/barang-masuk', [ManajerController::class, 'getBarangMasuk']);
    Route::get('/foto-goods', [UserController::class, 'redirectUser'])->name('redirect.user');
    Route::get('/data-user', [UserController::class, 'showUser'])->name('show.user');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.create');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
    Route::get('/user-log', [LogUserController::class, 'index'])->name('user-log');
    Route::get('/barangKeluar/report', [BarangKeluarController::class, 'cetakReport'])->name('barangKeluar.report');
    Route::patch('/barang/{id}/approve', [BarangController::class, 'approve'])->name('barang.approve');
    Route::post('/barang-keluar/store', [BarangKeluarController::class, 'store'])->name('barangKeluar.store');
    Route::patch('/barang/{id}/revisi', [BarangController::class, 'revisi'])->name('barang.revisi');

});

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');