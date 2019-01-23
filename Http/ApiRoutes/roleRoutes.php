<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/roles','middleware' => ['auth:api']], function (Router $router) {

  $router->post('/', [
    'as' => 'api.profile.roles.create',
    'uses' => 'RoleApiController@create',
  ]);
  $router->get('/', [
    'as' => 'api.profile.roles.index',
    'uses' => 'RoleApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' =>  'api.profile.roles.update',
    'uses' => 'RoleApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.profile.roles.delete',
    'uses' => 'RoleApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.profile.roles.show',
    'uses' => 'RoleApiController@show',
  ]);
  
});