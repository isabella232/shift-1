<?php

return [
    'form' => [
        'default_language' => [
            'label' => 'Default language',
            'hint' => 'Select the default language that will used for text output for this account'
        ],
        'domain' => [
            'label' => 'Account domain name',
            'hint' => 'The default/primary domain for the account.'
        ],
        'name' => [
            'label' => 'Name',
            'hint' => 'Enter the name of the account.'
        ],
        'owner' => [
            'label' => 'Owner',
            'hint' => 'Select a user that will act as the owner of this account'
        ]
    ],

    'table' => [
        'columns' => [
            'updated' => 'Updated',
            'domain' => 'Domain',
            'name' => 'Name',
            'owner' => 'Owner',
        ]
    ],

    'titles' => [
        'main' => 'Accounts',
        'new' => 'New account'
    ]
];
