<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\MessagePosted;
use App\User;
use App\Notifications\PushNotification;
use Tymon\JWTAuth\Facades\JWTAuth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::group(['middleware' => 'checkRoleAdmin', 'prefix' => 'admin'], function () {
        Route::post('sendMail', 'Api\NotificationController@sendNotificationAllMember');
        Route::get('notification-user/{id}', 'Api\NotificationController@getListCheckNotification');
        Route::get('users', 'Api\UserController@list');
        Route::post('users', 'Api\UserController@create');
    });
    Route::get('notification/{id}', 'Api\NotificationController@viewNotification');
    Route::get('notifications', 'Api\NotificationController@list');
    Route::post('saveToken', 'Api\UserController@saveToken');
});
