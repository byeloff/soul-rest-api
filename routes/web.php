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

$router->post('api/login', 'AuthController@login');
$router->post('api/logout', 'AuthController@logout');

$router->group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () use ($router) {

    // Usuários;
    $router->get('users',  [ 'uses' => 'UsersController@index' ]);
    $router->get('users/{id}', [ 'uses' => 'UsersController@show' ]);
    $router->post('users', [ 'uses' => 'UsersController@store' ]);
    $router->delete('users/{id}', [ 'uses' => 'UsersController@delete' ]);
    $router->put('users/{id}', [ 'uses' => 'UsersController@update' ]);

    // Posts;
    $router->get('posts',  [ 'uses' => 'PostsController@index' ]);
    $router->get('posts/{id}', [ 'uses' => 'PostsController@show' ]);
    $router->post('posts', [ 'uses' => 'PostsController@store' ]);
    $router->delete('posts/{id}', [ 'uses' => 'PostsController@delete' ]);
    $router->put('posts/{id}', [ 'uses' => 'PostsController@update' ]);

});