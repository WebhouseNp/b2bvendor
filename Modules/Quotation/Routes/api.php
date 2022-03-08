<?php

use Modules\Quotation\Http\Controllers\QuotationController;

Route::post('quotation', [QuotationController::class, 'store'])->name('quotation.store');
