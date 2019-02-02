<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/users'], function (Router $router) {


    $router->post('/', [
        'as' => 'api.profile.users.create',
        'uses' => 'UserApiController@create',
    ]);
    $router->get('/', [
        'as' => 'api.profile.users.index',
        'uses' => 'UserApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.profile.users.update',
        'uses' => 'UserApiController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.profile.users.delete',
        'uses' => 'UserApiController@delete',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.profile.users.show',
        'uses' => 'UserApiController@show',
    ]);

    $router->post('/media/upload', [
        'as' => 'api.profile.users.media.upload',
        'uses' => 'UserApiController@mediaUpload',
        'middleware' => ['auth:api']
    ]);
    $router->post('/media/delete', [
        'as' => 'api.profile.users.media.delete',
        'uses' => 'UserApiController@mediaDelete',
        'middleware' => ['auth:api']
    ]);

});