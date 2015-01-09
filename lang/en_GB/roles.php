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
            'default' => 'Default',
            'name' => 'Name',
            'updated' => 'Last updated',
            'users' => 'Users',
        ]
    ],

    'titles' => [
        'main' => 'Roles',
        'new' => 'New role'
    ]
];
