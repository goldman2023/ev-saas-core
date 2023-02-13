<?php
// Greedy Dashboard routes

use App\Http\Middleware\VendorMode;
use App\Http\Controllers\PageController;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomainAndVendorDomains::class,
    VendorMode::class,
])->group(function () {
    Route::get('/{data1}', [PageController::class, 'show_custom_page'])->name('custom-pages.show');
    Route::get('/{data1}/{data2}', [PageController::class, 'show_custom_page']);
});

