<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PicMitraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK PENGUNJUNG / BELUM LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login.page');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.process');

});

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK USER YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'show']
    )->name('profile.show');

    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::put(
        '/profile/password',
        [ProfileController::class, 'updatePassword']
    )->name('profile.password.update');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | DATA MITRA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mitra',
        [MitraController::class, 'index']
    )->name('mitra.index');

    Route::get(
        '/mitra/export',
        [MitraController::class, 'export']
    )->name('mitra.export');

    Route::get(
        '/mitra/create',
        [MitraController::class, 'create']
    )->name('mitra.create');

    Route::post(
        '/mitra',
        [MitraController::class, 'store']
    )->name('mitra.store');

    Route::get(
        '/mitra/{mitra}',
        [MitraController::class, 'show']
    )
        ->whereNumber('mitra')
        ->name('mitra.show');

    Route::get(
        '/mitra/{mitra}/edit',
        [MitraController::class, 'edit']
    )
        ->whereNumber('mitra')
        ->name('mitra.edit');

    Route::put(
        '/mitra/{mitra}',
        [MitraController::class, 'update']
    )
        ->whereNumber('mitra')
        ->name('mitra.update');

    Route::get(
        '/mitra/{mitra}/hapus',
        [MitraController::class, 'confirmDelete']
    )
        ->whereNumber('mitra')
        ->name('mitra.delete.confirm');

    Route::delete(
        '/mitra/{mitra}',
        [MitraController::class, 'destroy']
    )
        ->whereNumber('mitra')
        ->name('mitra.destroy');

    /*
    |--------------------------------------------------------------------------
    | DATA PIC
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pic',
        [PicMitraController::class, 'index']
    )->name('pic.index');

    Route::get(
        '/pic/create',
        [PicMitraController::class, 'create']
    )->name('pic.create');

    Route::post(
        '/pic',
        [PicMitraController::class, 'store']
    )->name('pic.store');

    Route::get(
        '/pic/{pic}/edit',
        [PicMitraController::class, 'edit']
    )
        ->whereNumber('pic')
        ->name('pic.edit');

    Route::put(
        '/pic/{pic}',
        [PicMitraController::class, 'update']
    )
        ->whereNumber('pic')
        ->name('pic.update');

    Route::get(
        '/pic/{pic}/hapus',
        [PicMitraController::class, 'confirmDelete']
    )
        ->whereNumber('pic')
        ->name('pic.delete.confirm');

    Route::delete(
        '/pic/{pic}',
        [PicMitraController::class, 'destroy']
    )
        ->whereNumber('pic')
        ->name('pic.destroy');

    /*
    |--------------------------------------------------------------------------
    | DATA PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/users',
        [UserController::class, 'index']
    )->name('users.index');

    Route::get(
        '/users/create',
        [UserController::class, 'create']
    )->name('users.create');

    Route::post(
        '/users',
        [UserController::class, 'store']
    )->name('users.store');

    Route::get(
        '/users/{user}/edit',
        [UserController::class, 'edit']
    )
        ->whereNumber('user')
        ->name('users.edit');

    Route::put(
        '/users/{user}',
        [UserController::class, 'update']
    )
        ->whereNumber('user')
        ->name('users.update');

    Route::get(
        '/users/{user}/hapus',
        [UserController::class, 'confirmDelete']
    )
        ->whereNumber('user')
        ->name('users.delete.confirm');

    Route::delete(
        '/users/{user}',
        [UserController::class, 'destroy']
    )
        ->whereNumber('user')
        ->name('users.destroy');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});
