<?php

/* FYI: This is central app routes  */

use App\Http\Controllers\Central\CentralController;
use App\Http\Controllers\Central\LoginTenantController;
use App\Http\Controllers\Central\RegisterTenantController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;
use Illuminate\Support\Facades\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;


Route::middleware([
    'web',
])
->group(function () {

        Route::get('/central/index', [CentralController::class, 'index'])->name('central.index');

        Route::view('/central/pricing', 'central.landing-pages.pricing')->name('central.pricing');

        Route::get('/central/register', [RegisterTenantController::class, 'show'])->name('central.tenants.register');
        Route::post('/register/submit', [RegisterTenantController::class, 'submit'])->name('central.tenants.register.submit');

        Route::get('/central/login', [LoginTenantController::class, 'show'])->name('central.tenants.login');
        Route::post('/central/login/submit', [LoginTenantController::class, 'submit'])->name('central.tenants.login.submit');
});
