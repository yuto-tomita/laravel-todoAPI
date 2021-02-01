<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['middleware' => ['api']], function () {
// });

// Route::group(['middleware' => 'api'], function () {
// });
Route::post('signup', 'App\Http\Controllers\Api\UserController@signup');
Route::post('signin', 'App\Http\Controllers\Api\UserController@signin');

