<?php

//Resgiter extra fields
$optionsRegisterExtraFields = [];
foreach (config('asgard.iprofile.config.registerExtraFields') as $fieldName)
  array_push($optionsRegisterExtraFields, ['label' => $fieldName, 'value' => $fieldName]);

//Address extra fields
$optionsUserAddressesExtraFields = [];
foreach (config('asgard.iprofile.config.addressesExtraFields') as $fieldName)
  array_push($optionsUserAddressesExtraFields, ['label' => $fieldName, 'value' => $fieldName]);


return [
  //Register Users
  'registerUsers' => [
    'name' => 'iprofile::registerUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.registerUsers'
    ],
  ],

  //Validete register with email
  'validateRegisterWithEmail' => [
    'name' => 'iprofile::validateRegisterWithEmail',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.validateRegisterWithEmail'
    ],
  ],

  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    'name' => 'iprofile::adminNeedsToActivateNewUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.adminNeedsToActivateNewUsers'
    ],
  ],

  'registerUsersWithSocialNetworks' => [
    'name' => 'iprofile::registerUsersWithSocialNetworks',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.registerUsersWithSocialNetworks'
    ],
  ],

  //Register extra field Active
  'registerExtraFieldsActive' => [
    'name' => 'active',
    'fakeFieldName' => 'iprofile::registerExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => "iprofile::settings.registerExtraFieldsActive",
      'options' => $optionsRegisterExtraFields,
      'multiple' => true,
      'useChips' => true
    ]
  ],

  //Register extra field Required
  'registerExtraFieldsRequired' => [
    'name' => 'required',
    'fakeFieldName' => 'iprofile::registerExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => "iprofile::settings.registerExtraFieldsRequired",
      'options' => $optionsRegisterExtraFields,
      'multiple' => true,
      'useChips' => true
    ]
  ],

  //User Addresses Extra Fields active
  'userAddressesExtraFieldsActive' => [
    'name' => 'active',
    'fakeFieldName' => 'iprofile::userAddressesExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => 'iprofile::settings.addressesExtraFieldsActive',
      'options' => $optionsRegisterExtraFields,
      'multiple' => true,
      'useChips' => true
    ]
  ],

  //User Addresses Extra Fields required
  'userAddressesExtraFieldsRequired' => [
    'name' => 'required',
    'fakeFieldName' => 'iprofile::userAddressesExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => 'iprofile::settings.addressesExtraFieldsRequired',
      'options' => $optionsRegisterExtraFields,
      'multiple' => true,
      'useChips' => true
    ]
  ],
];


//dd($fields);

//Response
return $fields;
