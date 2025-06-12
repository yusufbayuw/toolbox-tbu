<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\GoController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/go/{urlx}', [GoController::class, 'gotolink']);
Route::get('/link/{urlx}', [LinkController::class, 'linkstrees']);
Route::get('/cert/{urlx}', [CertificateController::class, 'generate']);
Route::get('/cert/val/{urlx}', [LinkController::class, 'linkstrees']);