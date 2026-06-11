<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuickCareController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->dashboardRoute());
    }
    return view('splash');
})->name('home');

Route::get('/welcome', [HomeController::class, 'welcome']);

Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

    Route::get('/doctors/{doctor}/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/doctors/{doctor}/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/doctors/{doctor}/slots', [BookingController::class, 'slots'])->name('booking.slots');
    Route::get('/appointments/{appointment}/success', [BookingController::class, 'success'])->name('appointments.success');
    Route::get('/appointments/{appointment}/payment', [BookingController::class, 'payment'])->name('appointments.payment');
    Route::post('/appointments/{appointment}/payment', [BookingController::class, 'processPayment'])->name('appointments.payment.process');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::get('/quick-care', [QuickCareController::class, 'create'])->name('quick-care.create');
    Route::post('/quick-care', [QuickCareController::class, 'store'])->name('quick-care.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/appointments/{appointment}/complete', [DoctorDashboardController::class, 'complete'])->name('appointments.complete');
    Route::patch('/appointments/{appointment}/cancel', [DoctorDashboardController::class, 'cancel'])->name('appointments.cancel');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/doctors', [AdminDashboardController::class, 'doctors'])->name('doctors');
    Route::get('/appointments', [AdminDashboardController::class, 'appointments'])->name('appointments');
});

require __DIR__.'/auth.php';
