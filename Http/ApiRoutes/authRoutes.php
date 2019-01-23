<?php

use Illuminate\Routing\Router;

/*=== AUTH ===*/
$router->group(['prefix' => '/auth'], function (Router $router) {

  /** @var Router $router */
  $router->post('login', [
    'as' => 'api.profile.login',
    'uses' => 'AuthApiController@login'
  ]);
  
  /** @var Router $router */
  $router->get('logout', [
    'as' => 'api.profile.logout',
    'uses' => 'AuthApiController@logout',
    'middleware' => ['auth:api']
  ]);
});