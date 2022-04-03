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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'RegistrationController@onRegister');
$router->post('/login', 'LoginController@onLogin');
$router->post('/tokenTest', ['middleware' => 'auth', 'uses' => 'LoginController@tokenTest']);
$router->post('/insert',['middleware'=>'auth','uses'=>'PhoneBookController@onInsert']);
$router->post('/select',['middleware'=>'auth','uses'=>'PhoneBookController@onSelect']);
$router->post('/delete',['middleware'=>'auth','uses'=>'PhoneBookController@onDelete']);

//$router->group(['prefix'=>'api'],function() use ($router){
//
//    $router->post('/login', 'AuthController@login');
//    $router->post('/register', 'AuthController@register');
//
//    $router->group(['middleware'=>'auth'],function() use ($router){
//        $router->post('/logout', 'AuthController@logout');
//        $router->get('/posts','PostController@index');
//        $router->post('/posts','PostController@store');
//        $router->put('/posts/{id}','PostController@update');
//        $router->delete('/posts/{id}','PostController@delete');
//    });
//});
