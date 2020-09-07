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

$router->post('/v1/add', [
    'uses' => 'CalculatorController@v1Addition'
]);

$router->post('/v1/subtract', [
    'uses' => 'CalculatorController@v1Subtraction'
]);

$router->post('/v1/multiply', [
    'uses' => 'CalculatorController@v1Multiplication'
]);

$router->post('/v1/divide', [
    'uses' => 'CalculatorController@v1Division'
]);

$router->post('/v1/squareRoot', [
    'uses' => 'CalculatorController@v1SquareRoot'
]);



$router->post('/v1/save', [
    'uses' => 'CalculatorController@v1SaveValue'
]);

$router->get('/v1/savedValue', [
    'uses' => 'CalculatorController@v1GetValue'
]);

$router->post('/v1/clear', [
    'uses' => 'CalculatorController@v1ClearValue'
]);



