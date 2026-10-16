<?php

use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LeadController;
use App\Http\Controllers\Public\LegalController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servicios', [ServiceController::class, 'index'])->name('services.index');
Route::get('/servicios/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/sobre-nosotros', [AboutController::class, 'index'])->name('about');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/cobertura', [HomeController::class, 'coverage'])->name('coverage');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::middleware(['throttle:leads'])->group(function () {
    Route::get('/solicitar-estudio', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/solicitar-estudio', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/gracias', [LeadController::class, 'thanks'])->name('leads.thanks');
});

Route::post('/cookie-consent', [ContactController::class, 'saveCookieConsent'])
    ->name('cookie.consent');

Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/privacidad', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/terminos', [LegalController::class, 'terms'])->name('terms');
    Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies');
});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';

require __DIR__.'/customer.php';
