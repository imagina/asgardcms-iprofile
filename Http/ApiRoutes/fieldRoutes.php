<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/fields','middleware' => ['auth:api']], function (Router $router) {
  
  $router->post('/', [
    'as' => 'api.profile.fields.create',
    'uses' => 'FieldApiController@create',
  ]);
  $router->get('/', [
    'as' => 'api.profile.fields.index',
    'uses' => 'FieldApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.profile.fields.update',
    'uses' => 'FieldApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.profile.fields.delete',
    'uses' => 'FieldApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.profile.fields.show',
    'uses' => 'FieldApiController@show',
  ]);
  
});