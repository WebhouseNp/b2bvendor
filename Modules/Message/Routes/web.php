<?php
// Route::get('chat', function () {
//     return view('message::chat.index');
// });

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/message', 'MessageController@index');
    Route::get('/chat/{slug}', 'MessageController@chat')->name('admin.chat');
    Route::post('/message', 'MessageController@store')->name('admin.message.store');
});
