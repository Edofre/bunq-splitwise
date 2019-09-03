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
    return redirect()->to('home');
});

// Authorization routes
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    // Home
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'bunq', 'as' => 'bunq.'], function () {
        // OAuth
        Route::get('/oauth', 'Bunq\AuthController@oauth')
            ->name('oauth.authorize');
        Route::get('/redirect', 'Bunq\AuthController@processRedirect')
            ->name('oauth.redirect');
        Route::post('/oauth', 'Bunq\AuthController@disconnect')
            ->name('oauth.disconnect');

        Route::get('/api-context', 'Bunq\ApiContextController@create')
            ->name('api-context');

        // Monetary accounts
        Route::get('/monetary-accounts', 'Bunq\MonetaryAccountController@index')
            ->name('monetary-accounts.index');
        Route::get('/monetary-accounts/{monetaryAccountId}', 'Bunq\MonetaryAccountController@show')
            ->name('monetary-accounts.show');
        Route::any('/monetary-accounts/{monetaryAccountId}/payments/data', 'Bunq\MonetaryAccountController@paymentData')
            ->name('monetary-accounts.payments.data');
        Route::post('/monetary-accounts/{monetaryAccountId}/payments/sync', 'Bunq\MonetaryAccountController@paymentSync')
            ->name('monetary-accounts.payments.sync');

        // Payments
        Route::get('/payments', 'Bunq\PaymentController@index')
            ->name('payments.index');
        Route::get('/payments/data', 'Bunq\PaymentController@data')
            ->name('payments.data');
        Route::get('/payments/filter', 'Bunq\PaymentController@filter')
            ->name('payments.filter');
        Route::post('/payments/process', 'Bunq\PaymentController@process')
            ->name('payments.process');
        Route::get('/payments/{payment}', 'Bunq\PaymentController@show')
            ->name('payments.show');
    });

    Route::group(['prefix' => 'splitwise', 'as' => 'splitwise.'], function () {
        // OAuth
        Route::get('/oauth', 'Splitwise\AuthController@oauth')
            ->name('oauth.authorize');
        Route::get('/redirect', 'Splitwise\AuthController@processRedirect')
            ->name('oauth.redirect');
        Route::post('/oauth', 'Splitwise\AuthController@disconnect')
            ->name('oauth.disconnect');

        // Friends
        Route::get('/friends', 'Splitwise\FriendController@index')
            ->name('friends.index');
        Route::get('/friends/{id}', 'Splitwise\FriendController@show')
            ->name('friends.show');

        // Groups
        Route::get('/groups', 'Splitwise\GroupController@index')
            ->name('groups.index');
        Route::get('/groups/{id}', 'Splitwise\GroupController@show')
            ->name('groups.show');
        // Groups
        Route::get('/expenses', 'Splitwise\ExpenseController@index')
            ->name('expenses.index');
        Route::get('/expenses/{id}', 'Splitwise\ExpenseController@show')
            ->name('expenses.show');

        // Users
        Route::get('/users/current', 'Splitwise\UserController@current')
            ->name('users.current');
    });
});
