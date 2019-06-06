<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'bunq'], function () use ($router) {

    $router->get('/monetary-accounts', ['uses' => 'Bunq\MonetaryAccountController@index']);
    $router->get('/monetary-accounts/{itemId}', ['uses' => 'Bunq\MonetaryAccountController@show']);

    $router->get('/week/{week}/{year}', ['uses' => 'Bunq\PaymentController@week']);
    $router->get('/month/{month}/{year}', ['uses' => 'Bunq\PaymentController@month']);
});

