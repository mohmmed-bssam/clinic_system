<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\AppointmentBookingController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/doctor/dashboard', DoctorDashboardController::class)
    ->middleware(['auth', 'verified', 'doctor'])
    ->name('doctor.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/appointments/create', [AppointmentBookingController::class, 'create'])
        ->name('appointments.create');
    Route::post('/appointments', [AppointmentBookingController::class, 'store'])
        ->name('appointments.store');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::get('dashboard', AdminDashboardController::class)
            ->name('dashboard');

        Route::resource('departments', DepartmentController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('appointments', AppointmentController::class)
            ->only(['index', 'create', 'store', 'show', 'update']);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('messages', MessageController::class)
            ->only(['index', 'show', 'destroy']);
        Route::resource('settings', SettingController::class)
            ->only(['index', 'store', 'update']);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
