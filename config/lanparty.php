<?php


return [

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ADMIN DATA
    |--------------------------------------------------------------------------
    | Data for default admin user created when seeding initial database
    */
    'admin_username' => env('ADMIN_USER_NAME', 'Sergi Tur Badenas'),
    'admin_email'     => env('ADMIN_USER_EMAIL', 'sergiturbadenas@gmail.com'),
    'admin_password'  => env('ADMIN_USER_PASSWORD'),
    'admin_givenName' => env('ADMIN_USER_GIVEN_NAME', 'Sergi'),
    'admin_sn1'  => env('ADMIN_USER_SN1', 'Tur'),
    'admin_sn2'  => env('ADMIN_USER_SN2', 'Badenas'),

    /*
    |--------------------------------------------------------------------------
    | PARTICIPANTS REGISTRATION START DATE
    |--------------------------------------------------------------------------
    | Start date participants could register to app.
    |
    */
    'registration_start_date' => env('REGISTRATION_START_DATE', '2018-03-15 12:00:00'),

    /*
    |--------------------------------------------------------------------------
    | SESSIONS
    |--------------------------------------------------------------------------
    | Anys/sessions de la lanparty
    |
    */
    'sessions' => env('LANPARTY_SESSIONS', [
        '2018',
        '2019'
    ]),

    /*
    |--------------------------------------------------------------------------
    | SESSIONS
    |--------------------------------------------------------------------------
    | Anys/sessions de la lanparty
    |
    */
    'current_session' => env('LANPARTY_SESSION_CURRENT_SESSION', '2019')
    
];
