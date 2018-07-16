<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iprofile'], function (Router $router) {
    $router->bind('profile', function ($id) {
        return app('Modules\Iprofile\Repositories\ProfileRepository')->find($id);
    });
    $router->get('profiles', [
        'as' => 'admin.account.profile.edit',
        'uses' => 'ProfileController@index',
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
// append



});
