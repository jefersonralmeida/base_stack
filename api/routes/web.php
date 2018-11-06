<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('activate-email', ['message' => 'Your account has been successfully activated']);
});

// Activate the account
Route::get('/user/activate/{token}', 'AuthController@ActivateAccount');
