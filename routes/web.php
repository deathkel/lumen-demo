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

if(env('APP_DEBUG')){
    $router->get('/apitest', 'ApiTestController@index');//接口文档
}

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/wx_mini_login', 'AuthController@wxMiniProgramLogin');//微信小程序登录


$router->group(['middleware' => ['jwt']],function() use ($router){
    $router->get('/test', 'TestController@index');
});



