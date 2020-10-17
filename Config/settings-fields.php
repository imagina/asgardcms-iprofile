<?php

return [
  //Register Users
  'registerUsers' => [
    'name' => 'iprofile::registerUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => '(trans)iprofile::settings.registerUsers'
    ],
  ],

  //Validete register with email
  'validateRegisterWithEmail' => [
    'name' => 'iprofile::validateRegisterWithEmail',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => '(trans)iprofile::settings.validateRegisterWithEmail'
    ],
  ],

  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    'name' => 'iprofile::adminNeedsToActivateNewUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => '(trans)iprofile::settings.adminNeedsToActivateNewUsers'
    ],
  ],

  'registerUsersWithSocialNetworks' => [
    'name' => 'iprofile::registerUsersWithSocialNetworks',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => '(trans)iprofile::settings.registerUsersWithSocialNetworks'
    ],
  ],

  //Register extra field Active
  'registerExtraFieldsActive' => [
    'name' => 'active',
    'fakeFieldName' => 'iprofile::registerExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => "(trans)iprofile::settings.registerExtraFieldsActive",
      'multiple' => true,
      'useChips' => true,
      'options' => [
        ['label' => 'cellularPhone', 'value' => 'cellularPhone'],
        ['label' => 'birthday', 'value' => 'birthday'],
        ['label' => 'identification', 'value' => 'identification'],
        ['label' => 'mainImage', 'value' => 'mainImage']
      ]
    ]
  ],

  //Register extra field Required
  'registerExtraFieldsRequired' => [
    'name' => 'required',
    'fakeFieldName' => 'iprofile::registerExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => "(trans)iprofile::settings.registerExtraFieldsRequired",
      'multiple' => true,
      'useChips' => true,
      'options' => [
        ['label' => 'cellularPhone', 'value' => 'cellularPhone'],
        ['label' => 'birthday', 'value' => 'birthday'],
        ['label' => 'identification', 'value' => 'identification'],
        ['label' => 'mainImage', 'value' => 'mainImage']
      ]
    ]
  ],

  //User Addresses Extra Fields active
  'userAddressesExtraFieldsActive' => [
    'name' => 'active',
    'fakeFieldName' => 'iprofile::userAddressesExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => '(trans)iprofile::settings.addressesExtraFieldsActive',
      'multiple' => true,
      'useChips' => true,
      'options' => [
        ['label' => 'company', 'value' => 'company'],
        ['label' => 'zipCode', 'value' => 'zipCode']
      ]
    ]
  ],

  //User Addresses Extra Fields required
  'userAddressesExtraFieldsRequired' => [
    'name' => 'required',
    'fakeFieldName' => 'iprofile::userAddressesExtraFields',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => '(trans)iprofile::settings.addressesExtraFieldsRequired',
      'multiple' => true,
      'useChips' => true,
      'options' => [
        ['label' => 'company', 'value' => 'company'],
        ['label' => 'zipCode', 'value' => 'zipCode']
      ]
    ]
  ],
];


//dd($fields);

//Response
return $fields;
