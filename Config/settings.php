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
  
  'registerUsersWithSocialNetworks' => [
    'description' => 'iprofile::settings.registerUsersWithSocialNetworks',
    'view' => 'checkbox',
    'default' => true,
  ],
  
  //Register Users
  'registerExtraFields' => [
    'custom' => true,
    'description' => 'iprofile::settings.registerExtraFields',
    'view' => 'register-extra-fields',
    'fields' => config('asgard.iprofile.config.registerExtraFields'),
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
