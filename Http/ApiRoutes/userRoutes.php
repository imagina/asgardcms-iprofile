<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/users','middleware' => ['auth:api']], function (Router $router) {

  
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
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.profile.users.delete',
    'uses' => 'UserApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.profile.users.show',
    'uses' => 'UserApiController@show',
  ]);
  
});