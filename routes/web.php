<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\GoController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\LinkController;
use App\Http\Middleware\VerifyConfigIntegrity;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/license/activate', [LicenseController::class, 'show'])->name('license.show');
Route::post('/license/activate', [LicenseController::class, 'activate'])->name('license.activate');
Route::get('/license/status', [LicenseController::class, 'status'])->name('license.status');

Route::middleware(VerifyConfigIntegrity::class)->group(function () {
    Route::get('/go/{urlx}', [GoController::class, 'gotolink']);
    Route::get('/link/{urlx}', [LinkController::class, 'linkstrees']);
    Route::get('/cert/{urlx}', [CertificateController::class, 'generate']);
    Route::get('/cert/val/{urlx}', [CertificateController::class, 'validate']);
});
