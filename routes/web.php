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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth'],], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'bunq', 'as' => 'bunq.'], function () {
        // OAuth (not used for now, using api context)
        Route::get('/oauth', ['uses' => 'Bunq\AuthController@oauth']);
        Route::get('/redirect', ['uses' => 'Bunq\AuthController@processRedirect']);
        Route::get('/token', ['uses' => 'Bunq\AuthController@token']);

        // Monetary accounts
        Route::get('/monetary-accounts', ['uses' => 'Bunq\MonetaryAccountController@index']);
        Route::get('/monetary-accounts/{itemId}', ['uses' => 'Bunq\MonetaryAccountController@show']);

        // Payments
        Route::get('/payments/{account}/week/{week}/{year}', ['uses' => 'Bunq\PaymentController@week']);
        Route::get('/payments/{account}/month/{month}/{year}', ['uses' => 'Bunq\PaymentController@month']);
    });

    Route::group(['prefix' => 'splitwise', 'as' => 'splitwise.'], function () {
        // OAuth
        Route::get('/oauth', ['uses' => 'Splitwise\AuthController@oauth']);
        Route::get('/redirect', ['uses' => 'Splitwise\AuthController@processRedirect']);
        Route::get('/token', ['uses' => 'Splitwise\AuthController@token']);

        // User
        Route::get('/users/current', ['uses' => 'Splitwise\UserController@current']);
    });
});
