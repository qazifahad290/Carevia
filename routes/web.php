<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuickCareController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

    Route::get('/doctors/{doctor}/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/doctors/{doctor}/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/doctors/{doctor}/slots', [BookingController::class, 'slots'])->name('booking.slots');
    Route::get('/appointments/{appointment}/success', [BookingController::class, 'success'])->name('appointments.success');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::get('/quick-care', [QuickCareController::class, 'create'])->name('quick-care.create');
    Route::post('/quick-care', [QuickCareController::class, 'store'])->name('quick-care.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
