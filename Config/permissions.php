<?php

return [
  'iprofile.api' => [
    'login' => 'iprofile::profiles.api.login',
  ],

  'iprofile.api.user' => [
    'index' => 'iprofile::user.api.list resource',
    'create' => 'iprofile::user.api.create resource',
    'edit' => 'iprofile::user.api.edit resource',
    'destroy' => 'iprofile::user.api.destroy resource',
    'permission' => 'iprofile::user.api.permission resource',
    'deparment' => 'iprofile::user.api.deparment resource',
  ],

  'iprofile.profiles' => [
    'index' => 'iprofile::profiles.list resource',
    'create' => 'iprofile::profiles.create resource',
    'edit' => 'iprofile::profiles.edit resource',
    'destroy' => 'iprofile::profiles.destroy resource',
  ],
  'iprofile.departments' => [
    'index' => 'iprofile::departments.list resource',
    'create' => 'iprofile::departments.create resource',
    'edit' => 'iprofile::departments.edit resource',
    'destroy' => 'iprofile::departments.destroy resource',
  ],

  'iprofile.bulkload' => [
    'import' => 'iprofile::profiles.bulkload.import',
    'export' => 'iprofile::profiles.bulkload.export',
  ],

    'iprofile.customfields' => [
        'index' => 'iprofile::customfields.list resource',
        'create' => 'iprofile::customfields.create resource',
        'edit' => 'iprofile::customfields.edit resource',
        'destroy' => 'iprofile::customfields.destroy resource',
    ],
// append



];
