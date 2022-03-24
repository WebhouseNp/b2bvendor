<?php

use Modules\Front\Http\Controllers\ConnectipsPaymentController;
use Modules\Front\Http\Controllers\EsewaPaymentController;

Route::get('payment/esewa_success', [EsewaPaymentController::class, 'success'])->name('payment.esewa_success');
Route::get('payment/esewa_failed', [EsewaPaymentController::class, 'failed'])->name('payment.esewa_failed');

Route::get('payment/connectips_success', [ConnectipsPaymentController::class, 'success'])->name('payment.connectips_success');
Route::get('payment/connectips_failed', [ConnectipsPaymentController::class, 'failed'])->name('payment.connectips_failed');
