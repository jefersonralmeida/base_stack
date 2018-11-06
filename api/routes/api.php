<?php

use Illuminate\Http\Request;

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

Route::get('/', function () {
    return ['Ta na mao'];
});

Route::post('/user/register', 'AuthController@register');


// routes protected by authentication
Route::group(['middleware' => 'auth:api'], function () {

    // me route
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // logout route
    Route::delete('/oauth/token', 'AuthController@logout');

    // Resend the activation email
    Route::get('/users/{user}/resend-activation', 'AuthController@sendActivationEmail');

    // list user notifications
    Route::get('/users/{user}/notifications', 'NotificationsController@index')->middleware(['is:user,user']);
    Route::get('/users/{user}/notifications/unread', 'NotificationsController@unread')->middleware(['is:user,user']);
    Route::get('/users/{user}/notifications/read', 'NotificationsController@read')->middleware(['is:user,user']);

    // show user notification
    Route::get('/notifications/{notification}', 'NotificationsController@show')->middleware(['is:owner,notification']);

    // just for users with activated emails
    Route::group(['middleware' => 'verified'], function () {

        Route::get('/verified', function () {
            return ['verified'];
        });

        // just for admins
        Route::group(['middleware' => 'is:admin'], function () {

            Route::get('/admin', function () {
                return ['admin'];
            });

        });

        // just for customers
        Route::group(['middleware' => 'is:customer'], function () {

            Route::post('/requests', 'RequestsController@new');

        });

        // just for providers
        Route::group(['middleware' => 'is:provider'], function () {

            Route::get('/provider', function () {
                return ['provider'];
            });

        });

    });

});
