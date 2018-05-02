<?php

use Acacha\User\GuestUser;
use App\Event;
use App\Group;
use App\Http\Resources\UserResource;
use App\InscriptionType;
use App\Number;
use App\Ticket;
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
              'participants_number' => 5,
              'regulation' => 'http s://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
              'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => 'img/Overwatch.jpeg',
                'tickets' => 10, // Número de grups
                'participants_number' => 6,
                'regulation' => 'https://docs.google.com/document/d/1OlM3ZcxyxiIz51R_tYeYiA1-lfiK-lyG-tMhRm8DHSk/edit',
                'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'group',
                'image' => 'img/CounterStrike.jpeg',
                'tickets' => 5, // Número d'usuaris es poden inscriure
                'participants_number' => 3,
                'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
                'published_at' => '2018-01-15 12:00:00',

            ],
            [
                'name' => 'Age Of empires',
                'inscription_type' => 'individual',
                'image' => 'img/AgeOfEmpires2.png',
                'tickets' => 12, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => null,
                'published_at' => '2018-01-15 12:00:00',
            ],
            [
                'name' => 'Muntatge equips ESBORRANY',
                'inscription_type' => 'individual',
                'image' => 'img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/15M_Acf3hBp0E7k2bCB8LwJV1ZZuiXx0B_w4SEZtY5DA/edit',
                'participants_number' => null,
                'published_at' => null
            ],
            [
                'name' => 'FIFA 18',
                'inscription_type' => 'individual',
                'image' => 'img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => null,
                'published_at' => null,
            ]

        ];

        foreach ($events as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
                'image' => $event['image'],
                'regulation' => $event['regulation'],
                'published_at' => $event['published_at'] ? Carbon::parse($event['published_at']) : null,
                'participants_number' => $event['participants_number']
            ]);
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

if (!function_exists('create_tickets')) {
    function create_tickets()
    {
        Ticket::addTickets(250);
    }
}

if (!function_exists('seed_database')) {
    function seed_database() {
        create_inscription_types();
        create_events();
        create_numbers();
        create_tickets();
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
            // Do nothing if user has role Manager already assigned
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
            dump('Event name: ' . $event->name);
            dump('inscription_type_id: ' . $event->inscription_type_id);
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

if (!function_exists('add_avatar_to_group')) {
    function add_avatar_to_group($group, $avatar)
    {
        $file = 'avatars/group_' . $group->id . '_avatar.' . pathinfo($avatar, PATHINFO_EXTENSION);;
        Storage::put($file, file_get_contents(public_path($avatar)));
        $group->avatar =  $file;
        $group->update();
    }
}

if (!function_exists('create_and_assign_members_to_group')) {
    function create_and_assign_members_to_group($group) {
        $leader = factory(User::class)->create();
        $member1 = factory(User::class)->create();
        $member2 = factory(User::class)->create();
        $member3 = factory(User::class)->create();
        $member4 = factory(User::class)->create();

        $group->add($leader);
        $group->add($member1);
        $group->add($member2);
        $group->add($member3);
        $group->add($member4);

    }
}


if (!function_exists('seed_groups')) {
    function seed_groups()
    {
        $group = Group::create( [
            'name' => 'Group without avatar field'
        ]);
        create_and_assign_members_to_group($group);

        $group = Group::create( [
            'name' => 'Group with incorrect avatar field'
        ]);
        create_and_assign_members_to_group($group);

        $group->avatar =  'avatars/nonexistingpath.png';
        $group->update();

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'e-LEMON-ators'
            ]),
            'img/group2.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Straight off the Couch'
            ]),
            'img/group3.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Cereal Killers'
            ]),
            'img/group4.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Not Fast, Just Furious',
            ]),
            'img/group5.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Super Heroes In Training',
            ]),
            'img/group1.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Smells Like Team Spirit',
            ]),
            'img/group2.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Victorious Secret',
            ]),
            'img/group3.jpg');
        create_and_assign_members_to_group($group);

        add_avatar_to_group(
            $group = Group::create( [
                'name' => 'Our Uniforms Match',
            ]),
            'img/group4.jpg');
        create_and_assign_members_to_group($group);

    }
}

if (!function_exists('logged_user')) {
    function logged_user()
    {
        return Auth::user();
    }
}

if (!function_exists('formatted_logged_user')) {
    function formatted_logged_user()
    {
        if(!Auth::user()) return new GuestUser();
        return json_encode((new UserResource(Auth::user()))->resolve());
    }
}


