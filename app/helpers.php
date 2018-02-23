<?php

use App\Event;
use App\Group;
use App\InscriptionType;
use App\Number;
use App\User;
use Carbon\Carbon;
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
              'image' => 'img/LoL.jpeg',
              'tickets' => 10, // Número de grups,
              'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
              'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => 'img/Overwatch.jpeg',
                'tickets' => 10, // Número de grups
                'regulation' => 'https://docs.google.com/document/d/1OlM3ZcxyxiIz51R_tYeYiA1-lfiK-lyG-tMhRm8DHSk/edit',
                'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'individual',
                'image' => 'img/CounterStrike.jpeg',
                'tickets' => 5, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
                'published_at' => '2018-01-15 12:00:00',

            ],
            [
                'name' => 'FIFA 18',
                'inscription_type' => 'individual',
                'image' => 'img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'published_at' => '2018-01-15 12:00:00',
            ],
            [
                'name' => 'Muntatge equips ESBORRANY',
                'inscription_type' => 'individual',
                'image' => 'img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/15M_Acf3hBp0E7k2bCB8LwJV1ZZuiXx0B_w4SEZtY5DA/edit',
                'published_at' => null
            ]
        ];

        foreach ($events as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
                'image' => $event['image'],
                'regulation' => $event['regulation'],
                'published_at' => $event['published_at'] ? Carbon::parse($event['published_at']) : null
            ]);
//            dump('Adding ' . $event['tickets'] . ' tickets to event ' . $event['name'] );
            $createdEvent->addTickets($event['tickets']);
        }
    }
}

if (!function_exists('create_numbers')) {
    function create_numbers()
    {
        Number::addNumbers(1000);
    }
}

if (!function_exists('seed_database')) {
    function seed_database() {
        create_inscription_types();
        create_events();
        create_numbers();
        initialize_roles();
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
        seed_database();

        $user = User::find(1);
        try {
        $user->assignRole('Manager');
        } catch (\Exception $e) {

        }

        foreach ( range(1,3) as $i) {
            Number::firstAvailableNumber()->assignUser($user);
        }
        //One extra number with description:
        Number::firstAvailableNumber()->assignUser($user,'Por que tú lo vales!');

        $users = factory(User::class,100)->create();

        foreach (  range(1,20) as $i) {
            Number::firstAvailableNumber()->assignUser($users->random());
        }

        $events = Event::published()->get();
        seed_groups();
        $groups = Group::all();
        foreach ($events as $event) {
            if ($event->inscription_type_id == 2) {
                foreach (range(1,5) as $i) {
                    $user = $users->pop();
                    dump('Adding user ' . $user->name . ' to event ' . $event->name);
                    $event->inscribeUser($user);
                }
            } else {
                foreach (range(1,5) as $i) {
                    $group = $groups->pop();
                    dump('Adding group ' . $group->name . ' to event ' . $event->name);
                    $event->inscribeGroup($group);
                }
            }
        }

    }
}

if (!function_exists('seed_groups')) {
    function seed_groups()
    {
        Group::create( [
            'name' => 'Fire Breathing Rubber Duckies'
        ]);

        Group::create( [
            'name' => 'e-LEMON-ators'
        ]);

        Group::create( [
            'name' => 'Straight off the Couch'
        ]);

        Group::create( [
            'name' => 'Cereal Killers'
        ]);

        Group::create( [
            'name' => 'Podunk Hopscotch Mafia',
            'avatar' => 'img/group5.jpg'
        ]);

        Group::create( [
            'name' => 'Not Fast, Just Furious'
        ]);

        Group::create( [
            'name' => 'Super Heroes In Training',
            'avatar' => 'img/group4.jpg'
        ]);

        Group::create( [
            'name' => 'Smells Like Team Spirit',
            'avatar' => 'img/group3.jpg'
        ]);

        Group::create( [
            'name' => 'Victorious Secret',
            'avatar' => 'img/group2.jpg'
        ]);

        Group::create( [
            'name' => 'Our Uniforms Match',
            'avatar' => 'img/group1.jpg'
        ]);

    }
}

if (!function_exists('logged_user')) {
    function logged_user()
    {
        return Auth::user();
    }
}
