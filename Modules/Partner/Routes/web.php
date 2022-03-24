<?php

Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::resource('partner', PartnerController::class);
    Route::resource('partner-type', PartnerTypeController::class);
    Route::get('partner-request', 'BecomePartnerController@index');
    Route::post('view-partner-request','BecomePartnerController@viewPartnerRequest')->name('viewPartnerRequest');
});
Route::post('partner-request','BecomePartnerController@store');
