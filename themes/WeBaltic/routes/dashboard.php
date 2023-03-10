<?php

use App\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;
use WeThemes\WeBaltic\App\Http\Controllers\OrderController;

// IMPORTANT: ALL names are prefixed with `dashboard.`

/* Custom Order Statuses and Document generation  */
Route::get('/order/{order_id}/change-cycle-status', [OrderController::class, 'change_cycle_status'])->name('order.change-status');
