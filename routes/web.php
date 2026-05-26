<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RideController;
use App\Http\Middleware\RequireAuth;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/', [RideController::class, 'index'])->name('home');
Route::get('/rides/{id}', [RideController::class, 'show'])->name('rides.show');

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Protected ─────────────────────────────────────────────────────────────────
Route::middleware(RequireAuth::class)->group(function () {
    Route::post('/rides/{id}/book', [DashboardController::class, 'bookRide'])->name('rides.book');

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'bookings'])->name('dashboard');
        Route::post('/bookings/{id}/cancel', [DashboardController::class, 'cancelBooking'])->name('bookings.cancel');
        Route::post('/bookings/{id}/confirm', [DashboardController::class, 'confirmBooking'])->name('bookings.confirm');

        Route::get('/rides', [DashboardController::class, 'rides'])->name('dashboard.rides');
        Route::post('/rides/{id}/cancel', [DashboardController::class, 'cancelRide'])->name('rides.cancel');

        Route::get('/rides/new', [DashboardController::class, 'createRide'])->name('rides.create');
        Route::post('/rides/new', [DashboardController::class, 'storeRide'])->name('rides.store');
    });
});
