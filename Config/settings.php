<?php


return [
  
  //Register Users
  'registerUsers' => [
    'description' => 'iprofile::settings.registerUsers',
    'view' => 'checkbox',
  ],
  
  //Register Users
  'registerExtraFields' => [
    'custom' => true,
    'description' => 'iprofile::settings.registerExtraFields',
    'view' => 'register-extra-fields',
    'fields' => config('asgard.iprofile.config.fields'),
    'default' => []
  ],


  //User Addresses Extra Fields
  'userAddressesExtraFields' => [
    'custom' => true,
    'description' => 'iprofile::settings.addressesExtraFields',
    'view' => 'address-extra-fields',
    'fields' => config('asgard.iprofile.config.addressesExtraFields'),
    'default' => []
  ],





];