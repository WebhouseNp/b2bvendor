<?php

// Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
//     Route::get('/message', 'MessageController@index');
//     Route::get('/chat/{slug}', 'MessageController@chat')->name('admin.chat');
//     Route::post('/message', 'MessageController@store')->name('admin.message.store');
// });

// messaging
Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', 'ChatRoomController@index');
    Route::get('/chat/{chatRoom}', 'ChatRoomController@show')->name('chatroom.show');
});
