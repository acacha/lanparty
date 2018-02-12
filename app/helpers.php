<?php

use App\Event;
use App\InscriptionType;
use App\Number;
use App\User;
use Spatie\Permission\Models\Role;

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
              'inscription_type' => 'group',
              'image' => 'img/LoL.jpeg'
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => 'img/Overwatch.jpeg'
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'individual',
                'image' => 'img/CounterStrike.jpeg'
            ],
            [
                'name' => 'FIFA 18',
                'inscription_type' => 'individual',
                'image' => 'img/Fifa18.jpeg'
            ]
        ];

        foreach ($events as $event) {
            Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
                'image' => $event['image']
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

if (!function_exists('initialize_roles')) {
    function initialize_roles()
    {
        $roles = [
            'Participant',
            'Manager'
        ];

        foreach ($roles as $role) {
            $role = Role::firstOrCreate(['name' => $role]);
        }
    }
}

if (!function_exists('create_admin_user')) {
    function create_admin_user()
    {
        factory(User::class)->create([
            'name'      => config('lanparty.admin_username'),
            'email'     => config('lanparty.admin_email'),
            'password'  => bcrypt(config('lanparty.admin_password')),
            'givenName' => config('lanparty.admin_givenName'),
            'sn1' => config('lanparty.admin_sn1'),
            'sn2' => config('lanparty.admin_sn2'),
        ]);
    }
}

if (!function_exists('first_user_as_manager')) {
    function first_user_as_manager()
    {
        $firstUser = User::all()->first();
        $firstUser->assignRole('Manager');
    }
}

if (!function_exists('seed_example_database')) {
    function seed_example_database()
    {
        $user = User::find(1);
        $numbers = factory(Number::class,3)->create();
        foreach ($numbers as $number) {
            $number->assignUser($user);
        }

        $users = factory(User::class,10)->create();

        seed_database();

        $numbers = factory(Number::class, 10)->create();
        foreach ($numbers as $number) {
            $number->assignUser($users->random());
        }
    }
}

if (!function_exists('logged_user')) {
    function logged_user()
    {
        return Auth::user();
    }
}
