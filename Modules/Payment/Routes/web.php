<?php

use Modules\Payment\Http\Controllers\TransactionController;

Route::group(['middleware' => 'auth'], function() {
    Route::get('transactions/{user}', [TransactionController::class, 'index'])->name('transactions.index');
});
