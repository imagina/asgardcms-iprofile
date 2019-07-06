<?php
return [
  'name' => 'Iprofile',
  'fields' =>[
    "cellularPhone",
    "birthday",
    "identification",
    "contacts",
    "socialNetworks",
    "mainImage"
  ],
  'addressesExtraFields' =>[
    "firstName",
    "lastName",
    "type"
  ],
  'modules-to-manage-permissions' => [
    "Iprofile",
  ],
  'imagesize' => ['width' => 800, 'height' => 800],
  'mediumthumbsize' => ['width' => 400, 'height' => 400],
  'smallthumbsize' => ['width' => 100, 'height' => 100],
  
    'file_remove' => [
        'rut' => ' ',
        'camaracomercio' => ' ',
        'revenue' => '',
        'patrimony' => '',
        'expenses' => '',
        'other_revenue' => '',
        'concept_other_revenue' => '',
    ],
  'iprofile' => [
    /*
    |--------------------------------------------------------------------------
    | Partials to include on page views
    |--------------------------------------------------------------------------
    | List the partials you wish to include on the different type page views
    | The content of those fields well be caught by the PostWasCreated and PostWasEdited events
    */
    'partials' => [
      'translatable' => [
        'create' => [],
        'edit' => [],
      ],
      'normal' => [
        'create' => [],
        'edit' => [],
      ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Array of directories to ignore when selecting the template for a page
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | Dynamic relations
    |--------------------------------------------------------------------------
    | Add relations that will be dynamically added to the Post entity
    */
    'relations' => [
      //        'extension' => function ($self) {
      //            return $self->belongsTo(PostExtension::class, 'id', 'post_id')->first();
      //        }
    ],
  ]
];
