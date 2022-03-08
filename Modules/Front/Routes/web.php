<?php

use Modules\Front\Http\Controllers\PaymentController;
use Modules\Front\Http\Controllers\QuotationController;

Route::get('payment/esewa_success', [PaymentController::class, 'esewaSuccess'])->name('payment.esewa_success');
Route::get('payment/esewa_failed', [PaymentController::class, 'esewaFailed'])->name('payment.esewa_failed');
