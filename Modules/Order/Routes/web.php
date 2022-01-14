<?php

use Modules\Order\Http\Controllers\OrderController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
