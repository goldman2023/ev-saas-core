<?php
// Greedy Tenant routes

use App\Http\Middleware\VendorMode;
use App\Http\Controllers\PageController;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomainAndVendorDomains::class,
    VendorMode::class,
])->group(function () {
    Route::get('/page/{slug}', [PageController::class, 'show_custom_page'])->name('custom-pages.show_custom_page');
});