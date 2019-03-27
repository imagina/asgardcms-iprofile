<?php

return [
    'name' => 'Iprofile',
    'time_update' => 6,
    'autoCreate'=>true,
    'default_mail_provider'=>'gmail.com',
    'fields' => [
        ['name' => '',
            'tipe' => '',
            'is_traslatable' => false,
            'required' => false
        ],

    ],
    'file_remove' => [
        'rut' => ' ',
        'camaracomercio' => ' ',
        'revenue' => '',
        'patrimony' => '',
        'expenses' => '',
        'other_revenue' => '',
        'concept_other_revenue' => '',
    ]
];
