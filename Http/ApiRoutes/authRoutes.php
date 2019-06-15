<?php

use Illuminate\Routing\Router;

/*=== AUTH ===*/
$router->group(['prefix' => '/auth'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  /** @var Router $router */
  $router->post('login', [
    'as' => $locale . 'api.iprofile.login',
    'uses' => 'AuthApiController@login',
  ]);

  /** @var Router $router */
  $router->get('me', [
    'as' => $locale . 'api.iprofile.me',
    'uses' => 'AuthApiController@me',
    'middleware' => ['auth:api']
  ]);

  /** @var Router $router */
  $router->get('logout', [
    'as' => $locale . 'api.iprofile.logout',
    'uses' => 'AuthApiController@logout',
    'middleware' => ['auth:api']
  ]);

  /** @var Router $router */
  $router->get('logout-all', [
    'as' => $locale . 'api.iprofile.logout.all',
    'uses' => 'AuthApiController@logoutAllSessions',
  ]);

  /** @var Router $router */
  $router->get('must-change-password', [
    'as' => $locale . 'api.iprofile.me.must.change.password',
    'uses' => 'AuthApiController@mustChangePassword',
    'middleware' => ['auth:api']
  ]);
});
