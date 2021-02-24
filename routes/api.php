<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Api\UserController;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

Route::group(['middleware' => ['api', 'cors']], function () {
	Route::post('signup', 'App\Http\Controllers\Api\UserController@signup');

	Route::get('/email/verify', function () {
		return view('auth.verify-email');
	})->middleware(['auth'])->name('verification.notice');
	
	Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
		$request->fulfill();
	})->middleware(['auth', 'signed'])->name('verification.verify');
	
	Route::post('signin', 'App\Http\Controllers\Api\UserController@signin');
});


// Route::get('profile', function () {
// 	// 確認済みユーザーのときだけ実行されるコード…
// })->middleware('verified');


