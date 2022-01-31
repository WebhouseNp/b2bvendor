<?php

use Illuminate\Support\Facades\Route;
use Modules\Message\Http\Controllers\ChatRoomController;

// Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
//     Route::get('/message', 'MessageController@index');
//     Route::get('/chat/{slug}', 'MessageController@chat')->name('admin.chat');
//     Route::post('/message', 'MessageController@store')->name('admin.message.store');
// });

// messaging
Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', [ChatRoomController::class, 'index']);
    Route::get('/chat/{chatRoom}', [ChatRoomController::class, 'show'])->name('chatroom.show');
});
