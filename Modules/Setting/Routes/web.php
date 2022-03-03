<?php

use Modules\Setting\Http\Controllers\NotificationSettingController;
use Modules\Setting\Http\Controllers\SastoWholesaleMallSettingController;

Route::prefix('settings')->group(function () {
    Route::get('sastowholesale-mall', [SastoWholesaleMallSettingController::class, 'index'])->name('settings.sastowholesale-mall.index');
    Route::post('sastowholesale-mall', [SastoWholesaleMallSettingController::class, 'store'])->name('settings.sastowholesale-mall.store');

    Route::get('notifications', [NotificationSettingController::class, 'index'])->name('settings.notification.index');
    Route::post('notifications/send-test-notification', [NotificationSettingController::class, 'sendTestNotification'])->name('settings.notification.send-test-notification');
});
