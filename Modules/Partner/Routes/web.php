<?php

Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::resource('partner', PartnerController::class);
    Route::resource('partner-type', PartnerTypeController::class);
});
