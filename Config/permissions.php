<?php

return [
    'iprofile.api' => [
        'login' => 'iprofile::profiles.api.login',
    ],
    'iprofile.user_fields' => [
        'index' => 'iprofile::user_fields.list resource',
        'create' => 'iprofile::user_fields.create resource',
        'edit' => 'iprofile::user_fields.edit resource',
        'destroy' => 'iprofile::user_fields.destroy resource',
    ],
    'iprofile.profiles' => [
        'index' => 'iprofile::user_fields.list resource',
        'create' => 'iprofile::user_fields.create resource',
        'edit' => 'iprofile::user_fields.edit resource',
        'destroy' => 'iprofile::user_fields.destroy resource',
    ],
    'iprofile.departments' => [
        'index' => 'iprofile::departments.list resource',
        'create' => 'iprofile::departments.create resource',
        'edit' => 'iprofile::departments.edit resource',
        'destroy' => 'iprofile::departments.destroy resource',
    ],
    'iprofile.addresses' => [
        'index' => 'iprofile::addresses.list resource',
        'create' => 'iprofile::addresses.create resource',
        'edit' => 'iprofile::addresses.edit resource',
        'destroy' => 'iprofile::addresses.destroy resource',
    ],
// append



];
