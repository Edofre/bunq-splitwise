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
    return $router->app->version(); // Lumen default, show readme?
});

$router->group(['prefix' => 'bunq'], function () use ($router) {
    // OAuth
    $router->get('/oauth', ['uses' => 'Bunq\AuthController@oauth']);
    $router->get('/redirect', ['uses' => 'Bunq\AuthController@processRedirect']);
    $router->get('/token', ['uses' => 'Bunq\AuthController@token']);

    $router->get('/monetary-accounts', ['uses' => 'Bunq\MonetaryAccountController@index']);
    $router->get('/monetary-accounts/{itemId}', ['uses' => 'Bunq\MonetaryAccountController@show']);

    $router->get('/payments/{account}/week/{week}/{year}', ['uses' => 'Bunq\PaymentController@week']);
    $router->get('/payments/{account}/month/{month}/{year}', ['uses' => 'Bunq\PaymentController@month']);
});

$router->group(['prefix' => 'splitwise'], function () use ($router) {
    // OAuth
    $router->get('/oauth', ['uses' => 'Splitwise\AuthController@oauth']);
    $router->get('/redirect', ['uses' => 'Splitwise\AuthController@processRedirect']);
    $router->get('/token', ['uses' => 'Splitwise\AuthController@token']);

    // User
    $router->get('/users/current', ['uses' => 'Splitwise\UserController@current']);
});

