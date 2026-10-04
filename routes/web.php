<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PicPerusahaanController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {

    Route::get(
        '/',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    );

    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.process');
});


Route::middleware('auth')->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    Route::resource(
        'perusahaan',
        PerusahaanController::class
    );


    Route::resource(
        'pic',
        PicPerusahaanController::class
    );


    Route::resource(
        'users',
        UserController::class
    )->except([
        'show'
    ]);


    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');
});