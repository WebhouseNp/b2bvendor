<?php

use Modules\Order\Http\Controllers\OrderController;
use Modules\Order\Http\Controllers\PackageController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/packages/{package}/update', [PackageController::class, 'update'])->name('orders.package.update');
});

Route::get('preview-package-mail', function() {
    $package = \Modules\Order\Entities\Package::first();
    // return $package;
    return new \App\Mail\PackageStatusChanged($package);
});
