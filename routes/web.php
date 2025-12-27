<?php

use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\LogAdminController;
use App\Http\Controllers\Admin\MovieAdminController;
use App\Http\Controllers\Admin\SeatAdminController;
use App\Http\Controllers\Admin\ShowtimeAdminController;
use App\Http\Controllers\Admin\TheaterAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TheaterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('movies.index')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{booking}/success', [ReservationController::class, 'success'])
        ->name('reservations.success');
    Route::get('/showtimes/{showtime}/seats', [ReservationController::class, 'seats'])
        ->name('showtimes.seats');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,employee'])
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard', [
                'movieCount' => \App\Models\Movie::count(),
                'theaterCount' => \App\Models\Theater::count(),
                'showtimeCount' => \App\Models\Showtime::count(),
                'pendingCount' => \App\Models\Booking::where('status', 'pending')->count(),
            ]);
        })->name('dashboard');

        Route::resource('movies', MovieAdminController::class)->except(['show']);
        Route::resource('theaters', TheaterAdminController::class)->except(['show']);
        Route::resource('showtimes', ShowtimeAdminController::class)->except(['show']);
        Route::resource('seats', SeatAdminController::class)->except(['show']);

        Route::get('bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
        Route::patch('bookings/{booking}/approve', [BookingAdminController::class, 'approve'])
            ->name('bookings.approve');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('users', [UserAdminController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserAdminController::class, 'create'])->name('users.create');
        Route::post('users', [UserAdminController::class, 'store'])->name('users.store');

        Route::get('logs', [LogAdminController::class, 'index'])->name('logs.index');
    });

require __DIR__.'/auth.php';
