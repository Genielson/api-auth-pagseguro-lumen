<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () {
    return microtime();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/', function () {
        return microtime();
    });

    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/me', 'AuthController@me');
        $router->post('/courses', 'CourseController@index');
        $router->post('/courses/create', 'CourseController@store');
        $router->post('/course/:id','CourseController@show');
        $router->post('/orders', 'OrderController@listUserOrder');
        $router->delete('/courses/delete', 'CourseController@destroy');
        $router->delete('/order/:id', 'OrderController@destroy');
        $router->put('/courses/:id', 'CourseController@update');
    });
});
