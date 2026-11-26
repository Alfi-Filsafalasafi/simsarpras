<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrasaranaController;
use Illuminate\Support\Facades\Route;

// Sementara diarahkan ke login, nanti diganti landing page (Beranda)
Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Data master: hanya Admin dan Petugas Sarpras
    Route::middleware('role:admin,petugas_sarpras')->group(function () {
        Route::resource('prasarana', PrasaranaController::class)
            ->parameters(['prasarana' => 'prasarana']);
    });
});