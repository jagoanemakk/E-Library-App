<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManajemenBukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route Auth
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});

Route::get('/register', [AuthController::class, 'register']);

Route::post('/register', [AuthController::class, 'store']);

Route::post('/login', [AuthController::class, 'authenticate']);

Route::post('/logout', [AuthController::class, 'logout']);

// Route Dashboard Member
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Route Dashboard Super Admin
Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/add-admin', [AdminController::class, 'index']);
    Route::post('/add-admin', [AdminController::class, 'store']);

    Route::prefix('dt')->group(function () {
        Route::get('/add-admin/{id}', [AdminController::class, 'edit']);
        Route::post('/add-admin', [AdminController::class, 'update']);
        Route::delete('/add-admin/{id}', [AdminController::class, 'destroy']);
        Route::get('/add-admin', [AdminController::class, 'listAdmin']);
    });
});

// Route Dashboard Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/manajemen-buku', [ManajemenBukuController::class, 'index']);
    Route::post('/manajemen-buku', [ManajemenBukuController::class, 'store']);
    Route::get('/koleksi', [MemberController::class, 'index']);

    Route::prefix('dx')->group(function () {
        // Route Manajemen Buku
        Route::get('/manajemen-buku/{id}', [ManajemenBukuController::class, 'edit']);
        Route::post('/manajemen-buku', [ManajemenBukuController::class, 'update']);
        Route::delete('/manajemen-buku/{id}', [ManajemenBukuController::class, 'destroy']);
        Route::get('/manajemen-buku', [ManajemenBukuController::class, 'listBuku']);
    });
    
    // Route Member
    Route::prefix('xt')->group(function () {
        Route::get('/peminjaman', [MemberController::class, 'listBuku']);
    });
});
