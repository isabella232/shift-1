<?php

return [
    // Emails required by the application
    'emails' => [
        'support' => '',
    ],

    // Honeypot api key configuration
    'honeypot' => [
        'api_key' => ''
    ],

    // Language / localisation configuration settings
    'language' => [
        'autoloads' => ['shift'],               // Packages to load language files for
        'locales' => ['en_GB'],                 // Locales (language file translations) to pull in
    ],

    // The private and public keys for recaptcha usage
    'recaptcha' => [
        'keys' => [
            'private' => '',
            'public' => ''
        ]
    ],

    // Url settings. If you want Shift located at something like /admin/, for example, put 'admin'
    'url' => ''
];
