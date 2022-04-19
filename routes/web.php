<?php

use Illuminate\Support\Facades\Route;

Route::get('/refresh-csrf', function() {
    return csrf_token();
});



