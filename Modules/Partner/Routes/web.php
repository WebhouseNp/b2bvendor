<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('partner', PartnerController::class);
    Route::resource('partner-type', PartnerTypeController::class);
});
