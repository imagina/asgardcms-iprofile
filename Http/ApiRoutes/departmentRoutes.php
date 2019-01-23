<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/departments','middleware' => ['auth:api']], function (Router $router) {

  
  $router->post('/', [
    'as' => 'api.profile.departments.create',
    'uses' => 'DepartmentApiController@create',
  ]);
  $router->get('/', [
    'as' => 'api.profile.departments.index',
    'uses' => 'DepartmentApiController@index',
  ]);
  
  $router->get('/settings', [
    'as' => 'api.profile.departments.settings',
    'uses' => 'DepartmentApiController@getSettings',
    'middleware' => ['auth:api']
  ]);
  
  $router->put('/{criteria}', [
    'as' => 'api.profile.departments.update',
    'uses' => 'DepartmentApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.profile.departments.delete',
    'uses' => 'DepartmentApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' =>  'api.profile.departments.show',
    'uses' => 'DepartmentApiController@show',
  ]);
  
});
