<?php


return [
  //Register Users
  'registerUsers' => [
    'description' => 'iprofile::settings.registerUsers',
    'view' => 'checkbox',
  ],

  //Validete register with email
  'validateRegisterWithEmail' => [
    'description' => 'iprofile::settings.validateRegisterWithEmail',
    'view' => 'checkbox',
  ],

  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    'description' => 'iprofile::settings.adminNeedsToActivateNewUsers',
    'view' => 'checkbox',
  ],

  //Register Users
  'registerExtraFields' => [
    'custom' => true,
    'description' => 'iprofile::settings.registerExtraFields',
    'view' => 'register-extra-fields',
    'fields' => [
      "cellularPhone",
      "birthday",
      "identification",
      "mainImage"
    ],
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
