<?php

use Illuminate\Routing\Router;

/*=== AUTH ===*/
$router->group(['prefix' => '/auth'], function (Router $router) {
  /** @var Router $router */
  $router->post('login', [
    'as' => 'api.login',
    'uses' => 'ApiAuthController@apiLogin'
  ]);

  /** @var Router $router */
  $router->get('logout', [
    'as' => 'api.login',
    'uses' => 'ApiAuthController@apiLogout',
    'middleware' => ['auth:api']
  ]);
});

/*=== USERS ===*/
$router->group(['prefix' => '/users'], function (Router $router) {

  //Index
  $router->get('/', [
    'as' => 'api.user.index',
    'uses' => 'ApiUserController@index',
    'middleware' => [
      'auth:api'
      //'ApiCan:iprofile.api.user.index'
    ]
  ]);

  //ShowUser
  $router->get('/{id}', [
    'as' => 'api.user.show',
    'uses' => 'ApiUserController@show',
    'middleware' => [
      'auth:api'
      //'token-can:iprofile.api.user.index'
    ]
  ]);

  //Update
  $router->put('/{id}', [
    'as' => 'api.user.update',
    'uses' => 'ApiUserController@update',
    'middleware' => [
      'auth:api'
      //'token-can:iprofile.api.user.edit'
    ]
  ]);

  //CreateUser
  $router->post('/', [
    'as' => 'api.user.create',
    'uses' => 'ApiUserController@create',
    'middleware' => [
      'auth:api'
      //'token-can:iprofile.api.user.create'
    ]
  ]);

  /*$router->delete('/{id}', [
    'as' => 'user.delete',
    'uses' => 'ApiUserController@delete',
  ]);*/
});

/*=== PROFILE ===*/
$router->group(['prefix' => '/profile'], function (Router $router) {

  //Update
  $router->put('/me', [
    'as' => 'api.profile.update',
    'uses' => 'ApiProfileController@update',
    'middleware' => ['auth:api']
  ]);

    //Update
    $router->put('/{id}', [
        'as' => 'api.profile.update',
        'uses' => 'ApiProfileController@update',
        'middleware' => ['auth:api']
    ]);
    //Update
    $router->post('/customfield', [
        'as' => 'api.profile.update',
        'uses' => 'ApiProfileController@update',
        'middleware' => ['auth:api']
    ]);

});

/*=== ROLES ===*/
$router->group(['prefix' => '/roles'],function (Router $router){

  //IndexRole
  $router->get('/', [
    'as' => 'api.role.index',
    'uses' => 'ApiRolesController@index',
    'middleware' => ['auth:api']
  ]);

});

/*=== DEPARTMENTS ===*/
$router->group(['prefix' => '/departments'], function (Router $router) {

  $router->get('/', [
    'as' => 'api.department.index',
    'uses' => 'ApiDepartmentsController@index',
    'middleware' => ['auth:api']
  ]);
});