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

    if (!auth()->guest()) {
        return redirect()->to('home');
    }

    return view('welcome');
});

// Authorization routes
Auth::routes();

Route::group(['middleware' => ['auth'],], function () {

    // Home
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'bunq', 'as' => 'bunq.'], function () {
        // OAuth (not used for now, using api context)
        Route::get('/oauth', 'Bunq\AuthController@oauth')
            ->name('oauth.authorize');
        Route::get('/redirect', 'Bunq\AuthController@processRedirect')
            ->name('oauth.redirect');
        Route::get('/token', 'Bunq\AuthController@token')
            ->name('oauth.token');

        // Monetary accounts
        Route::get('/monetary-accounts', 'Bunq\MonetaryAccountController@index')
            ->name('monetary-accounts.index');
        Route::get('/monetary-accounts/{itemId}', 'Bunq\MonetaryAccountController@show')
            ->name('monetary-accounts.show');

        // Payments
        Route::get('/payments/{account}/week/{week}/{year}', 'Bunq\PaymentController@week')
            ->name('payments.week');
        Route::get('/payments/{account}/month/{month}/{year}', 'Bunq\PaymentController@month')
            ->name('payments.year');
    });

    Route::group(['prefix' => 'splitwise', 'as' => 'splitwise.'], function () {
        // OAuth
        Route::get('/oauth', 'Splitwise\AuthController@oauth')
            ->name('oauth.authorize');
        Route::get('/redirect', 'Splitwise\AuthController@processRedirect')
            ->name('oauth.redirect');
        Route::post('/oauth', 'Splitwise\AuthController@disconnect')
            ->name('oauth.disconnect');

        // Groups
        Route::get('/groups/list', 'Splitwise\GroupController@list')
            ->name('groups.list');

        // Users
        Route::get('/users/current', 'Splitwise\UserController@current')
            ->name('users.current');
    });
});
