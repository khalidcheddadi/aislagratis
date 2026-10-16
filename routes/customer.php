<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\InstallationController;
use App\Http\Controllers\Customer\LeadController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\PropertyController;
use App\Http\Controllers\Customer\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'active', 'role:customer'])
    ->prefix('mi-cuenta')
    ->name('customer.')
    ->group(function () {

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('mis-solicitudes', [LeadController::class, 'index'])->name('leads.index');
        Route::get('mis-solicitudes/{lead}', [LeadController::class, 'show'])->name('leads.show');

        Route::resource('inmuebles', PropertyController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->parameters(['inmuebles' => 'property'])
            ->names('properties');

        Route::get('mis-instalaciones', [InstallationController::class, 'index'])->name('installations.index');
        Route::get('mis-instalaciones/{installation}', [InstallationController::class, 'show'])->name('installations.show');

        Route::post('instalaciones/{installation}/valorar', [ReviewController::class, 'store'])
            ->name('reviews.store');
        Route::get('opiniones', [ReviewController::class, 'index'])->name('reviews.index');

        Route::get('perfil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('perfil/contraseña', [ProfileController::class, 'changePassword'])->name('profile.password');
    });
