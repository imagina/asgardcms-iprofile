<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iprofile'], function (Router $router) {

    $router->group(['prefix' =>'/profiles'], function (Router $router) {
        $router->bind('user_id', function ($id) {
            return app('Modules\Iprofile\Repositories\UserRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iprofile.profiles.index',
            'uses' => 'ProfileController@index',
            'middleware' => 'can:iprofile.profiles.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iprofile.profiles.create',
            'uses' => 'ProfileController@create',
            'middleware' => 'can:user.users.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iprofile.profiles.store',
            'uses' => 'ProfileController@store',
            'middleware' => 'can:user.users.create'
        ]);
        $router->get('{user_id}/edit', [
            'as' => 'admin.iprofile.profiles.edit',
            'uses' => 'ProfileController@edit',
            'middleware' => 'can:user.users.edit'
        ]);
        $router->get('me', [
            'as' => 'admin.iprofile.profiles.me',
            'uses' => 'ProfileController@me',
            'middleware' => 'can:user.users.edit'
        ]);
        $router->put('{user_id}', [
            'as' => 'admin.iprofile.department.update',
            'uses' => 'ProfileController@update',
            'middleware' => 'can:user.users.edit'
        ]);
        $router->delete('{user_id}', [
            'as' => 'admin.iprofile.department.destroy',
            'uses' => 'ProfileController@destroy',
            'middleware' => 'can:user.users.destroy'
        ]);
        $router->group(['prefix' =>'{user_id}/address'], function (Router $router) {
            $router->bind('address', function ($id) {
                return app('Modules\Iprofile\Repositories\AddressRepository')->find($id);
            });
            $router->get('/', [
                'as' => 'admin.iprofile.address.index',
                'uses' => 'AddressController@index',
                'middleware' => 'can:iprofile.addresses.index'
            ]);
            $router->get('create', [
                'as' => 'admin.iprofile.address.create',
                'uses' => 'AddressController@create',
                'middleware' => 'can:iprofile.addresses.create'
            ]);
            $router->post('/', [
                'as' => 'admin.iprofile.address.store',
                'uses' => 'AddressController@store',
                'middleware' => 'can:iprofile.addresses.create'
            ]);
            $router->get('{address}/edit', [
                'as' => 'admin.iprofile.address.edit',
                'uses' => 'AddressController@edit',
                'middleware' => 'can:iprofile.addresses.edit'
            ]);
            $router->put('{address}', [
                'as' => 'admin.iprofile.address.update',
                'uses' => 'AddressController@update',
                'middleware' => 'can:iprofile.addresses.edit'
            ]);
            $router->delete('{address}', [
                'as' => 'admin.iprofile.address.destroy',
                'uses' => 'AddressController@destroy',
                'middleware' => 'can:iprofile.addresses.destroy'
            ]);
        });

    });
    $router->group(['prefix' =>'/departments'], function (Router $router) {
        $router->bind('department', function ($id) {
            return app('Modules\Iprofile\Repositories\DepartmentRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iprofile.department.index',
            'uses' => 'DepartmentController@index',
            'middleware' => 'can:iprofile.departments.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iprofile.department.create',
            'uses' => 'DepartmentController@create',
            'middleware' => 'can:iprofile.departments.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iprofile.department.store',
            'uses' => 'DepartmentController@store',
            'middleware' => 'can:iprofile.departments.create'
        ]);
        $router->get('{department}/edit', [
            'as' => 'admin.iprofile.department.edit',
            'uses' => 'DepartmentController@edit',
            'middleware' => 'can:iprofile.departments.edit'
        ]);
        $router->put('{department}', [
            'as' => 'admin.iprofile.department.update',
            'uses' => 'DepartmentController@update',
            'middleware' => 'can:iprofile.departments.edit'
        ]);
        $router->delete('{department}', [
            'as' => 'admin.iprofile.department.destroy',
            'uses' => 'DepartmentController@destroy',
            'middleware' => 'can:iprofile.departments.destroy'
        ]);
    });



});
