<?php

use App\Event;
use App\InscriptionType;

if (!function_exists('create_inscription_types')) {
    function create_inscription_types() {
        $types = [ 'group', 'individual' ];

        foreach ($types as $type) {
            InscriptionType::firstOrCreate([
                'value' => $type
            ]);
        }
    }
}

if (!function_exists('create_events')) {
    function create_events() {
        $events = [
            [
              'name' => 'League Of Legends',
              'inscription_type' => 'group'
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group'
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'individual'
            ],
            [
                'name' => 'FIFA 17',
                'inscription_type' => 'individual'
            ]
        ];

        foreach ($events as $event) {
            Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
            ]);
        }
    }
}

if (!function_exists('seed_database')) {
    function seed_database() {
        create_inscription_types();
        create_events();
    }
}

if (!function_exists('assignPermission')) {
    function assignPermission($role, $permission) {
        if (! $role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }
}

if (!function_exists('initialize_permissions')) {
    function initialize_permissions()
    {
        initialize_relationships_management_permissions();
    }
}

if (!function_exists('create_admin_user')) {
    function create_admin_user()
    {
        factory(User::class)->create([
            'name'     => env('ADMIN_USER_NAME', 'Sergi Tur Badenas'),
            'email'    => env('ADMIN_USER_EMAIL', 'sergiturbadenas@gmail.com'),
            'password' => bcrypt(env('ADMIN_USER_PASSWORD')),
        ]);
    }
}

if (!function_exists('first_user_as_manager')) {
    function first_user_as_manager()
    {
        $firstUser = User::all()->first();
        $firstUser->assignRole('manage-relationships');
        $firstUser->givePermissionTo('disable-validation');
    }
}
