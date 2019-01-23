<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/addresses','middleware' => ['auth:api']], function (Router $router) {

  
  $router->post('/', [
    'as' =>  'api.profile.addresses.create',
    'uses' => 'AddressApiController@create',
  ]);
  $router->get('/', [
    'as' =>  'api.profile.addresses.index',
    'uses' => 'AddressApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.profile.addresses.update',
    'uses' => 'AddressApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' =>  'api.profile.addresses.delete',
    'uses' => 'AddressApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' =>  'api.profile.addresses.show',
    'uses' => 'AddressApiController@show',
  ]);
  
});