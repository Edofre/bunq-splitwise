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

Route::group(['prefix' => 'bunq', 'as' => 'bunq.'], function () {
    // Monetary accounts
    Route::get('/monetary-accounts', 'Api\Bunq\MonetaryAccountController@index')
        ->name('monetary-accounts.index');
});
