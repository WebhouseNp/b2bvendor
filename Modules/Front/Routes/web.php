<?php

use Modules\Front\Http\Controllers\PaymentController;
use Modules\Front\Http\Controllers\QuotationController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::get('/allquotations', [QuotationController::class, 'index'])->name('allquotations');
});

Route::get('payment/esewa_success', [PaymentController::class, 'esewaSuccess'])->name('payment.esewa_success');
Route::get('payment/esewa_failed', [PaymentController::class, 'esewaFailed'])->name('payment.esewa_failed');
