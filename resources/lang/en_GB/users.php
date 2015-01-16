<?php

return [
    'form' => [
        'first_name' => [
            'label' => 'First name'
        ],
        'last_name' => [
            'label' => 'Last name'
        ],
        'email' => [
            'label' => 'Email address',
            'hint' => 'Please enter a valid email address.'
        ],
        'password' => [
            'label' => 'Password',
            'hint' => 'Only required if you wish to change your password.'
        ],
        'password_confirmation' => [
            'label' => 'Password confirmation',
            'hint' => 'If you have provided a password above, please confirm by re-entering it again.'
        ]
    ],

    'table' => [
        'columns' => [
            'email' => 'Email',
            'name' => 'Name',
            'updated' => 'Last updated',
        ]
    ],

    'titles' => [
        'main' => 'Users',
        'new' => 'New user'
    ]
];
