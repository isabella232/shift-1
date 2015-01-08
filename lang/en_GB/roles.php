<?php

return [
    'form' => [
        'name' => [
            'label' => 'Name',
            'hint' => 'Enter the name of the role.'
        ],
        'default' => [
            'label' => 'Is this the default role for newly registered users?'
        ]
    ],

    'table' => [
        'columns' => [
            'created' => 'Created',
            'default' => 'Default',
            'name' => 'Name',
            'users' => 'Users',
        ]
    ],

    'titles' => [
        'main' => 'Roles',
        'new' => 'New role'
    ]
];
