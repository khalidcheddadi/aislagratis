<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CoverageAreaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InstallationController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'active', 'role:admin|sales|technician'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', DashboardController::class)->middleware('role:admin|sales')->name('dashboard');

        Route::resource('leads', LeadController::class)->only(['index', 'show'])->middleware('role:admin|sales');
        Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus'])->middleware('role:admin|sales')
            ->name('leads.status');
        Route::get('leads/{lead}/export', [LeadController::class, 'export'])->middleware('role:admin|sales')
            ->name('leads.export');

        Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store']);
        Route::patch('appointments/{appointment}/status',
            [AppointmentController::class, 'updateStatus'])->name('appointments.status');

        Route::resource('installations', InstallationController::class)->only(['index', 'create', 'store']);
        Route::patch('installations/{installation}/status',
            [InstallationController::class, 'updateStatus'])->name('installations.status');

        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class)
                ->except(['show', 'create', 'store', 'destroy']);
            Route::resource('services', ServiceController::class)->except(['show']);
            Route::resource('coverage-areas', CoverageAreaController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('faqs', FaqController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('partners', PartnerController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        });

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/{notification}/read',
            [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('notifications/read-all',
            [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    });
