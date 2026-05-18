<?php

use App\Http\Controllers\OrderController;

Route::resource('orders', OrderController::class);

Route::get('orders-export', [OrderController::class, 'export'])
    ->name('orders.export');