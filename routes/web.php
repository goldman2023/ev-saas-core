<?php

use App\Http\Controllers\Central\LoginTenantController;
use App\Http\Controllers\Central\RegisterTenantController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Ev\ComponentController;

Route::get('/refresh-csrf', function() {
    return csrf_token();
});



