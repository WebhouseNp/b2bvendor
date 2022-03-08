<?php

use Illuminate\Support\Facades\Route;
use Modules\Quotation\Http\Controllers\QuotationController;

Route::get('quotations', [QuotationController::class, 'index'])->name('quotations.index');
Route::get('quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
Route::delete('quotations/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');