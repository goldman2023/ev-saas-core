<?php

use App\Http\Controllers\Central\CentralController;
use Illuminate\Support\Facades\Route;

Route::get('/refresh-csrf', function() {
    return csrf_token();
});



Route::middleware([
    'web',
])
->group(function () {

        Route::get('/', [CentralController::class, 'index'])->name('central.index');

        Route::view('/central/pricing', 'central.landing-pages.pricing')->name('central.pricing');

        Route::get('/central/register', [RegisterTenantController::class, 'show'])->name('central.tenants.register');
        Route::post('/register/submit', [RegisterTenantController::class, 'submit'])->name('central.tenants.register.submit');

        Route::get('/central/login', [LoginTenantController::class, 'show'])->name('central.tenants.login');
        Route::post('/central/login/submit', [LoginTenantController::class, 'submit'])->name('central.tenants.login.submit');
});
