<?php

use Illuminate\Routing\Router;
/** @var Router $router */

require('ApiRoutes/authRoutes.php');

$router->group(['prefix' => '/profile/'], function (Router $router) {

    //======  AUTH

    //======  ADDRESSES
    require('ApiRoutes/addressRoutes.php');

    //======  FIELDS
    require('ApiRoutes/fieldRoutes.php');

    //======  DEPARTMENTS
    require('ApiRoutes/departmentRoutes.php');

    //======  ROLES
    require('ApiRoutes/roleRoutes.php');

    //======  USERS
    require('ApiRoutes/userRoutes.php');

});