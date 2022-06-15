<?php

/* TODO: Start creating fresh API routes */
use App\Http\Middleware\VendorMode;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\WeQuizController;

Route::middleware([
    'api',
    InitializeTenancyByDomainAndVendorDomains::class,
    // PreventAccessFromCentralDomains::class,
    VendorMode::class,
])->group(function () {
    
    Route::middleware('tenancy')->group(function () {
        Route::get('/we-quizz-result/{id}', [WeQuizController::class, 'save_result']);

    });

    // Route::middleware('auth')->group(function () {
    // });


});
