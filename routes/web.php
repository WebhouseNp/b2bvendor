<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\Front\JobseekerLoginController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Front\DefaultController;
use Illuminate\Support\Facades\Artisan;
use Pusher\Pusher;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/admin/login');

Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
    // dd(Artisan::output());
    // return redirect()->route('home');
});

//=======================vendor page Router============================================//

Route::get('/vendor-homepage', function () {
    return view('vendor_homepage');
});
Route::get('/vendor-login', function () {
    return view('vendor_login');
});
Route::get('/vendor-registor', function () {
    return view('register');
});
Route::get('/forget-password', function () {
    return view('forgetpassword');
});
Route::get('/passwod-resetform/{token}',function($token){
    $token = $token;
    return view('reset_password')->with(compact('token'));
});
Route::get('/account-verification', function () {
    return view('account_verification');
});
// Route::get('passwod-resetform/{token}', 'PasswordResetController@passwordResetForm')->name('passwordResetForm');
//==========================end vendor====================================================//

Route::group([], function () {
    // Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
    // Route::post('postLogin', [LoginController::class, 'postLogin'])->name('admin.postLogin');
    Route::get('password-reset', [PasswordResetController::class, 'resetForm'])->name('password-reset');
    Route::post('send-email-link', [PasswordResetController::class, 'sendEmailLink'])->name('sendEmailLink');
    // Route::get('reset-password/{token}', [PasswordResetController::class, 'passwordResetForm'])->name('passwordResetForm');
    Route::post('update-password', [PasswordResetController::class, 'updatePassword'])->name('updatePassword');
});


// Route::group(['middleware' => 'auth', 'prefix' => 'admin',], function () {
//     Route::get('logout', [LoginController::class, 'admin__logout'])->name('admin.logout');
// });
// Route::group(['middleware' => ['admin', 'auth'], 'prefix' => 'admin',], function () {
//     // Route::get('/test', function () {
//     //     return auth()->roles()->get();
//     // });
// });


Route::get('/test', [App\Http\Controllers\TestController::class, 'broadcast']);

Route::post('/pusher/auth', function (Request $request) {
    $pusher_id = "1283512";
    $pusher_app_key = "cbe0b7b8904e2ede8292";
    $pusher_app_secret = "e934d010ddd74158d0ba";
    $pusher = new Pusher($pusher_app_key, $pusher_app_secret, $pusher_id);
    $auth = $pusher->socketAuth($request->channel_name, $request->socket_id);
    // $auth = str_replace('\\', '', $auth);
    // header('Content-Type: application/javascript');
    // echo ($callback . '(' . $auth . ');');
    // return;
    // $authString = hash_hmac("sha256", $signature_string, $pusher_app_secret);
    return $auth;
})->middleware('auth');

// messaging
Route::get('/chat', 'ChatController@index');
