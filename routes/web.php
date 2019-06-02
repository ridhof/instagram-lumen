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

$router->group(['prefix'=>'api/v1'], function() use($router){

    $router->group(['prefix'=>'user'], function () use($router){
        $router->post('/register', 'UserController@register');
        $router->post('/login', 'UserController@login');
        $router->post('/nama', 'UserController@nama');
        $router->post('/profil', 'UserController@profile');
        $router->get('/users', 'UserController@index');
        $router->post('/cari', 'UserController@cari');
    });

    $router->group(['prefix'=>'post'], function() use($router){
        $router->get('/', 'PostController@index');
        $router->get('/thumbnail/{username}', 'PostController@thumbnail');
        $router->get('/{id}', 'PostController@postById');
    });

    $router->group(['prefix'=>'komentar'], function() use($router){
        $router->post('/', 'PostController@createComment');
    });

    $router->group(['prefix'=>'like'], function() use($router){
        $router->get('/{id}/{username}', 'PostController@likeCertainUser');
        $router->post('/', 'PostController@createLike');
    });
});

$router->get('/key', function() {
    return str_random(32);
});

$router->get('/date', function () {
    return date("d M Y - h:i:sa", time());
});
