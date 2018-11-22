<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iprofile'], function (Router $router) {
    $router->bind('profile', function ($id) {
        return app('Modules\Iprofile\Repositories\ProfileRepository')->find($id);
    });
    $router->get('profiles', [
        'as' => 'admin.account.profile.index',
        'uses' => 'ProfileController@index',
    ]);
    $router->get('profiles/edit', [
        'as' => 'admin.account.profile.edit',
        'uses' => 'ProfileController@edit',
    ]);
    $router->post('profiles', [
        'as' => 'admin.iprofile.profile.store',
        'uses' => 'ProfileController@store',
        'middleware' => 'can:iprofile.profiles.create'
    ]);
    $router->put('profiles/{profile}', [
        'as' => 'admin.iprofile.profile.update',
        'uses' => 'ProfileController@update',
        'middleware' => 'can:iprofile.profiles.edit'
    ]);
    $router->bind('address', function ($id) {
        return app('Modules\Iprofile\Repositories\AddressRepository')->find($id);
    });
    $router->get('addresses', [
        'as' => 'admin.iprofile.address.index',
        'uses' => 'AddressController@index',
        'middleware' => 'can:iprofile.addresses.index'
    ]);
    $router->get('addresses/create', [
        'as' => 'admin.iprofile.address.create',
        'uses' => 'AddressController@create',
        'middleware' => 'can:iprofile.addresses.create'
    ]);
    $router->post('addresses', [
        'as' => 'admin.iprofile.address.store',
        'uses' => 'AddressController@store',
        'middleware' => 'can:iprofile.addresses.create'
    ]);
    $router->get('addresses/{address}/edit', [
        'as' => 'admin.iprofile.address.edit',
        'uses' => 'AddressController@edit',
        'middleware' => 'can:iprofile.addresses.edit'
    ]);
    $router->put('addresses/{address}', [
        'as' => 'admin.iprofile.address.update',
        'uses' => 'AddressController@update',
        'middleware' => 'can:iprofile.addresses.edit'
    ]);
    $router->delete('addresses/{address}', [
        'as' => 'admin.iprofile.address.destroy',
        'uses' => 'AddressController@destroy',
        'middleware' => 'can:iprofile.addresses.destroy'
    ]);
    $router->bind('department', function ($id) {
        return app('Modules\Iprofile\Repositories\DepartmentRepository')->find($id);
    });
    $router->get('departments', [
        'as' => 'admin.iprofile.department.index',
        'uses' => 'DepartmentController@index',
        'middleware' => 'can:iprofile.departments.index'
    ]);
    $router->get('departments/create', [
        'as' => 'admin.iprofile.department.create',
        'uses' => 'DepartmentController@create',
        'middleware' => 'can:iprofile.departments.create'
    ]);
    $router->post('departments', [
        'as' => 'admin.iprofile.department.store',
        'uses' => 'DepartmentController@store',
        'middleware' => 'can:iprofile.departments.create'
    ]);
    $router->get('departments/{department}/edit', [
        'as' => 'admin.iprofile.department.edit',
        'uses' => 'DepartmentController@edit',
        'middleware' => 'can:iprofile.departments.edit'
    ]);
    $router->put('departments/{department}', [
        'as' => 'admin.iprofile.department.update',
        'uses' => 'DepartmentController@update',
        'middleware' => 'can:iprofile.departments.edit'
    ]);
    $router->delete('departments/{department}', [
        'as' => 'admin.iprofile.department.destroy',
        'uses' => 'DepartmentController@destroy',
        'middleware' => 'can:iprofile.departments.destroy'
    ]);


    $router->group(['prefix' =>'bulkload'], function (Router $router){

        $router->get('index',[
            'as'=>'admin.iprofile.bulkload.index',
            'uses'=>'ProfileController@indeximport',
            'middleware'=>'can:iprofile.bulkload.import',
        ]);

        $router->post('import',[
            'as'=>'admin.iprofile.bulkload.import',
            'uses'=>'ProfileController@importProfiles',
             'middleware'=>'can:iprofile.bulkload.import',
        ]);

    });
// append




});
