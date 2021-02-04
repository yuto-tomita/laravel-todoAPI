<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Api\UserController;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

// Route::group(['middleware' => ['api']], function () {
// });

// Route::group(['middleware' => 'api'], function () {
// });
Route::post('signup', 'App\Http\Controllers\Api\UserController@signup');
Route::post('signin', 'App\Http\Controllers\Api\UserController@signin');

// Route::get('profile', function () {
// 	// 確認済みユーザーのときだけ実行されるコード…
// })->middleware('verified');

Route::get('/email/verify', function () {
	return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
	$request->fulfill();

	return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

