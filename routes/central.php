<?php

/* FYI: This is central app routes  */

use App\Http\Controllers\Central\LoginTenantController;
use App\Http\Controllers\Central\RegisterTenantController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
])
->group(function () {
    Route::view('/', 'central.landing-pages.landing')->name('central.landing');
    Route::view('/pricing', 'central.landing-pages.pricing')->name('central.pricing');

    Route::get('/register', [RegisterTenantController::class, 'show'])->name('central.tenants.register');
    Route::post('/register/submit', [RegisterTenantController::class, 'submit'])->name('central.tenants.register.submit');

    Route::get('/login', [LoginTenantController::class, 'show'])->name('central.tenants.login');
    Route::post('/login/submit', [LoginTenantController::class, 'submit'])->name('central.tenants.login.submit');
});
