<?php

use Acacha\User\GuestUser;
use App\Event;
use App\Group;
use App\Http\Resources\UserResource;
use App\InscriptionType;
use App\Number;
use App\Partner;
use App\Prize;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Role as LanPartyRole;

if (!function_exists('initialize_partners')) {
    function initialize_partners()
    {
        Partner::firstOrCreate([
            'name' => 'Ajuntament de Tortosa',
            'category' => 'Or'
        ]);

        Partner::firstOrCreate([
            'name' => 'Beep',
            'category' => 'Or'
        ]);

        Partner::firstOrCreate([
            'name' => 'The Workshop',
            'category' => 'Or'
        ]);

        Partner::firstOrCreate([
            'name' => 'PC Serveis',
            'category' => 'Plata'
        ]);

        Partner::firstOrCreate([
            'name' => 'DISI',
            'category' => 'Plata'
        ]);

        Partner::firstOrCreate([
            'name' => 'AGI',
            'category' => 'Plata'
        ]);

        Partner::firstOrCreate([
            'name' => 'EPorts',
            'category' => 'Plata'
        ]);

        Partner::firstOrCreate([
            'name' => 'SecurityPla',
            'category' => 'Plata'
        ]);

        Partner::firstOrCreate([
            'name' => 'Altercom 21',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => 'Globals',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => 'Ferreteria Garcia',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => 'Jabil',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => 'Querol',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => 'Electrotic',
            'category' => 'Bronze'
        ]);

        Partner::firstOrCreate([
            'name' => "Departament d'informàtica",
            'category' => 'Or'
        ]);

    }
}

if (!function_exists('initialize_prizes')) {
    function initialize_prizes()
    {
        Prize::firstOrCreate([
            'name' => 'Samarreta LAN Party',
            'description' => '',
            'notes' => '',
            'value' => 0,
            'partner_id' => Partner::findByName('Ajuntament de Tortosa')->id,
            'multiple' => true
        ]);

        Prize::firstOrCreate([
            'name' => 'ARCADE STICK NETWAY GAMING ARCADE FIGHTER PS3/PC',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'ARCADE STICK NETWAY GAMING ARCADE FIGHTER PS3/PC',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id
        ]);

        Prize::firstOrCreate([
            'name' => '1  GAMEPAD NETWAY GAMING EVO PS3/PC/ANDROID WIRELESS',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'TECLAT KROSS KROM',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 7400,
            'partner_id' => Partner::findByName('Beep')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Volant i pedals',
            'description' => '',
            'notes' => '1r classificat Counter Strike',
            'value' => 5999,
            'partner_id' => Partner::findByName('Beep')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Hoverboard Airstream All Road',
            'description' => '',
            'notes' => '1r classificat concurs Hardware',
            'value' => 14620,
            'partner_id' => Partner::findByName('Beep')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'DOC Hoverboard Off Road',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 24775,
            'partner_id' => Partner::findByName('The Workshop')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Samsung 860 EVO Basic SSD 500GB SATA3 + Curs Visual Basic',
            'description' => '',
            'notes' => '1r classificat concurs de programació',
            'value' => 23000,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Curs Visual Bàsic',
            'description' => '',
            'notes' => '2n classificat de programació',
            'value' => 12550,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Curs Visual Bàsic',
            'description' => '',
            'notes' => '3r classificat de programació',
            'value' => 12550,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Tablet GT10W3 Tablet 3Go, RAM 2GB 10" W10 IPS 1280x800 32GB" (Windows 8.1)',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 18700,
            'partner_id' => Partner::findByName('AGI')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Monitor de 23 polzades',
            'description' => '',
            'notes' => '1r classificat Ae of Empires 2 HD',
            'value' => 12900,
            'partner_id' => Partner::findByName('PC Serveis')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => '1 router domèstic TP-Link Archer C2 1',
            'description' => '',
            'notes' => '2n classificat concurs programació',
            'value' => 3999,
            'partner_id' => Partner::findByName('EPorts')->id
        ]);

        Prize::firstOrCreate([
            'name' => '1 router domèstic TP-Link Archer C2 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('EPorts')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Discs dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats League of Legends',
            'value' => 7500,
            'partner_id' => Partner::findByName('SecurityPla')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Discs dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats Counter Strike',
            'value' => 7500,
            'partner_id' => Partner::findByName('SecurityPla')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Torre de música amb bluetooth PROSTIMA SAM',
            'description' => '',
            'notes' => 'Guanyador concurs cartell LAN Party',
            'value' => 7500,
            'partner_id' => Partner::findByName('Altercom 21')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Dron Parrot Ardrone2.0 Elite Edition',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 14900,
            'partner_id' => Partner::findByName('Globals')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Teclat Trust AVONN Gaming',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2999,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Ratolí ORNA 3200dpi OPTICAL',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2695,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Auriculars MARS GAMING MH2',
            'description' => '',
            'notes' => '2n classificat Age Of Empires 2',
            'value' => 1575,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Teclat Gaming  Razer Ornata Chroma',
            'description' => '',
            'notes' => '1r classificat Counter Strike',
            'value' => 8999,
            'partner_id' => Partner::findByName('Jabil')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'Kit Tacens Mars Gaming MACP1(teclat, auriculars, ratolí i alfombreta)',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2095,
            'partner_id' => Partner::findByName('Querol')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Auricular Energy System energy audio headphones bluetooth',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2490,
            'partner_id' => Partner::findByName('Querol')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'MiniDrone 3GO Maverick 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2300,
            'partner_id' => Partner::findByName('Querol')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Xassis ATX',
            'description' => '',
            'notes' => '2n classificat Concurs de hardware',
            'value' => 6000,
            'partner_id' => Partner::findByName('Electrotic')->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => '1 funda consola, 1 ratolí i alfombreta 1',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 1000,
            'partner_id' => Partner::findByName('Electrotic')->id
        ]);

        Prize::firstOrCreate([
            'name' => '1 funda consola, 1 ratolí i alfombreta 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 1000,
            'partner_id' => Partner::findByName('Electrotic')->id
        ]);

        Prize::firstOrCreate([
            'name' => 'Disc dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats League of Legends',
            'value' => 6500,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'SMARTWATCH NETWAY TEMPUS PLUS',
            'description' => '',
            'notes' => '1r classificats Overwatch (6)+ 2 sorteig dissabte',
            'value' => 3000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'MEMORIA 16 GB REMOVIBLE KINGSTON USB 3.0 DT G4',
            'description' => '',
            'notes' => '2n classificats Overwatch (6)+ League of Legends(5)+ Counter Strike(3)',
            'value' => 1000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999 // Ja assignat
        ]);

        Prize::firstOrCreate([
            'name' => 'MEMORIA 16 GB REMOVIBLE KINGSTON USB 3.0 DT G4',
            'description' => '',
            'notes' => '2n classificats Overwatch (6)+ League of Legends(5)+ Counter Strike(3)',
            'value' => 1000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999 // Ja assignat
        ]);
    }
}

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
              'image' => '/img/LoL.jpeg',
              'tickets' => 10, // Número de grups,
              'participants_number' => 5,
              'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
              'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => '/img/Overwatch.jpeg',
                'tickets' => 10, // Número de grups
                'participants_number' => 6,
                'regulation' => 'https://docs.google.com/document/d/1OlM3ZcxyxiIz51R_tYeYiA1-lfiK-lyG-tMhRm8DHSk/edit',
                'published_at' => '2018-01-15 12:00:00'
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'group',
                'image' => '/img/CounterStrike.jpeg',
                'tickets' => 10, // Número d'usuaris es poden inscriure
                'participants_number' => 3,
                'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
                'published_at' => '2018-01-15 12:00:00',

            ],
            [
                'name' => 'Age Of empires',
                'inscription_type' => 'individual',
                'image' => '/img/AgeOfEmpires2.png',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => null,
                'published_at' => '2018-01-15 12:00:00',
            ],
            [
                'name' => 'Muntatge equips ESBORRANY',
                'inscription_type' => 'individual',
                'image' => '/img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/15M_Acf3hBp0E7k2bCB8LwJV1ZZuiXx0B_w4SEZtY5DA/edit',
                'participants_number' => null,
                'published_at' => null
            ],
            [
                'name' => 'FIFA 18',
                'inscription_type' => 'individual',
                'image' => '/img/Fifa18.jpeg',
                'tickets' => 15, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => null,
                'published_at' => null,
            ],
            [
                'name' => 'Capture The Flag',
                'inscription_type' => 'group',
                'image' => '/img/CaptureTheFlag.jpeg',
                'tickets' => 20, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => 3,
                'published_at' => '2019-04-27 12:00:00',
            ],
            [
                'name' => 'Event archivat',
                'inscription_type' => 'individual',
                'image' => '/img/Fifa18.jpeg',
                'tickets' => 20, // Número d'usuaris es poden inscriure
                'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
                'participants_number' => null,
                'published_at' => '2018-01-15 12:00:00',
                'deleted_at' => '2018-01-13 12:00:00',
            ]
        ];

        foreach ($events as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'session' => in_array('session', $event) ? $event['session'] : '',
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


if (!function_exists('create_events_2019')) {
    function create_events_2019() {
        $events2019 = [
            [
              'name' => 'League Of Legends',
              'session' => '2019',
              'inscription_type' => 'group',
              'image' => '/img/LoL.jpeg',
              'tickets' => 25, // Número de grups,
              'participants_number' => 5,
              'regulation' => 'https://drive.google.com/open?id=1ngi-LN20BYe6tkvIOQfWeEq7UJSfY_oZ',
              'published_at' => '2019-05-01 12:00:00'
            ],
            [
              'name' => 'Overwatch',
              'session' => '2019',
              'inscription_type' => 'group',
              'image' => '/img/Overwatch.jpeg',
              'tickets' => 15, // Número de grups
              'participants_number' => 6,
              'regulation' => 'https://drive.google.com/open?id=19p7BYETZjk_lFf7WS1ruITVrTF8RsKT6',
              'published_at' => '2019-05-01 12:00:00'
            ],
            [
              'name' => 'Counter Strike GO',
              'session' => '2019',
              'inscription_type' => 'group',
              'image' => '/img/CounterStrike.jpeg',
              'tickets' => 25, // Número de grups
              'participants_number' => 3,
              'regulation' => 'https://drive.google.com/open?id=1w_IZlY_udxGlIIm-KsY2KfnBC96EmfsD',
              'published_at' => '2019-05-01 12:00:00'

            ],
            [
              'name' => 'Capture The Flag',
              'session' => '2019',
              'inscription_type' => 'group',
              'image' => '/img/CaptureTheFlag.jpeg',
              'tickets' => 8, // Número de grups
              'participants_number' => 3,
              'regulation' => 'https://drive.google.com/open?id=18G315NKo6bPSJredIt_A7LJMdfpOHa4j',
              'published_at' => '2019-05-01 12:00:00'
            ],
            [
              'name' => 'FIFA 19',
              'session' => '2019',
              'inscription_type' => 'individual',
              'image' => '/img/Fifa18.jpeg',
              'tickets' => 32, // Número d'usuaris es poden inscriure
              'regulation' => 'https://drive.google.com/open?id=1ED-Ui5zMLEU7KvYwUuf5umFvVAP8OupP',
              'participants_number' => null,
              'published_at' => '2019-05-01 12:00:00'
            ],
            [
              'name' => 'Programació Python-JavaScript',
              'session' => '2019',
              'inscription_type' => 'individual',
              'image' => '/img/code.jpeg',
              'tickets' => 20, // Número d'usuaris es poden inscriure
              'regulation' => 'https://drive.google.com/open?id=1V8kBbF-Jg-gBH6mdevjzbp5ljL6QhH42',
              'participants_number' => null,
              'published_at' => '2019-05-01 12:00:00'
            ]
        ];

        foreach ($events2019 as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'session' => $event['session'],
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
        Number::addNumbers(10,config('lanparty.session'));
    }
}

if (!function_exists('create_tickets')) {
    function create_tickets()
    {
        Ticket::addTickets(250,config('lanparty.session'));
    }
}

if (!function_exists('seed_database')) {
    function seed_database() {
        create_inscription_types();
        create_events();
        create_numbers();
        create_tickets();
        initialize_roles();
        initialize_partners();
        initialize_prizes();

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
        ];

        foreach ($roles as $role) {
            $role = Role::firstOrCreate(['name' => $role]);
        }

        initialize_manager_role();
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
            'admin' => true
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
            Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        }
        //One extra number with description:
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user,'Por que tú lo vales!');

        $users = factory(User::class,100)->create();

        foreach (  range(1,20) as $i) {
            Number::firstAvailableNumber(config('lanparty.session'))->assignUser($users->random());
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

if (!function_exists('lanparty_config_to_json')) {
    function lanparty_config_to_json()
    {
        return json_encode([
            'session' => config('lanparty.session'),
            'sessions' => config('lanparty.sessions')
        ]);
    }
}

if (!function_exists('initialize_manager_role')) {
    function initialize_manager_role()
    {
        $role = Role::firstOrCreate(['name' => LanPartyRole::MANAGER['name']]);
        $permissions = manager_permissions();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            try {
                $role->givePermissionTo($permission);
            } catch (\Exception $e) {}
        }
    }
}

if (!function_exists('manager_permissions')) {
    function manager_permissions()
    {
        return [
            'events.index',
            'events.store',
            'events.destroy',
            'events.show',
            'events.update',
            'managers.index',
            'prizes.index',
            'managers.invitation.send',
            'partners.index',
            'partners.show',
            'partners.store',
            'partners.destroy',
            'partners.update',
            'users.index',
            'user.manager.destroy',
            'archived.events.store',
            'archived.events.destroy',
            'all.events.index',
            'tickets.store',
            'tickets.destroy',
            'numbers.store',
            'numbers.destroy'
        ];
    }
}

if (! function_exists('map_collection')) {
    function map_collection($collection)
    {
        return $collection->map(function($item) {
            return $item->map();
        });
    }
}

if (!function_exists('initialize_gates')) {
    function initialize_gates()
    {
        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

//        Gate::define('show-personal-data', function ($user) {
//            return $user->hasRole(['UsersManager']);
//        } );
//
//        Gate::define('calculate-lessons', function ($user) {
//            return $user->hasRole(['LessonsManager']);
//        });
    }
}


if (!function_exists('create_flags_2019')) {
    function create_flags_2019() {

        DB::table('flags')->insert([
            'name' => 'F1',
            'longName' => 'HanEncontradoMiBackDoorBender',
            'flag' => 'FLAG{HanEncontradoMiBackDoorBender}',
            'points' => 10,
        ]);


        DB::table('flags')->insert([
            'name' => 'F2',
            'longName' => 'Besa mi brillante trasero metálico',
            'flag' => 'FLAG{Besa mi brillante trasero metálico.}',
            'points' => 10,
        ]);

        DB::table('flags')->insert([
            'name' => 'F3',
            'longName' => 'Oh Dios mío, ella está atrapada en un bucle infinito de repetición... ¡Y Fry es idiota!',
            'flag' => 'FLAG {Oh Dios mío, ella está atrapada en un bucle infinito de repetición... ¡Y Fry es idiota!}',
            'points' => 10,
        ]);

        DB::table('flags')->insert([
            'name' => 'F4',
            'longName' => 'Dale duro Fry. Dale...',
            'flag' => 'FLAG{Dale duro Fry. Dale...}',
            'points' => 10,
        ]);

        DB::table('flags')->insert([
            'name' => 'F5',
            'longName' => '¡Maldito abrelatas!¡Mataste a mi padre y ahora has venido a por mí!',
            'flag' => 'FLAG{¡Maldito abrelatas!¡Mataste a mi padre y ahora has venido a por mí!}',
            'points' => 10,
        ]);

        DB::table('flags')->insert([
            'name' => 'F6',
            'longName' => 'Tengo que revisar mi programa. Mmm... ¡Sí!',
            'flag' => 'FLAG{Tengo que revisar mi programa. Mmm... ¡Sí!}',
            'points' => 10,
        ]);

        DB::table('flags')->insert([
            'name' => 'F7',
            'longName' => '131333',
            'flag' => 'FLAG{131333}',
            'points' => 20,
        ]);

        DB::table('flags')->insert([
            'name' => 'F8',
            'longName' => 'Y allaaaaaa vamoooooooos',
            'flag' => 'FLAG{Y allaaaaaa vamoooooooos}',
            'points' => 20,
        ]);

        DB::table('flags')->insert([
            'name' => 'F9',
            'longName' => 'El espacio parece extenderse sin límites. Hasta que llegas al final y aparece un mono lanzándote barriles',
            'flag' => 'FLAG{El espacio parece extenderse sin límites. Hasta que llegas al final y aparece un mono lanzándote barriles.}',
            'points' => 30,
        ]);


    }


    if (!function_exists('create_partners_2019')) {
        function create_partners_2019() {

            DB::table('partners')->insert([
                'name' => 'Ajuntament de Tortosa',
                'session' => '2019',
                'category' => null,
                'avatar' => '/img/logos/Ajuntament.jpg'
            ]);

            DB::table('partners')->insert([
                  'name' => 'Fusteria Almendros',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Almendros.jpg'
            ]);

            DB::table('partners')->insert([
                  'name' => 'Alonso',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Alonso.jpg'
            ]);

          DB::table('partners')->insert([
                'name' => 'Altercom',
                'session' => '2019',
                'category' => null,
                'avatar' => '/img/logos/Altercom.jpg'
          ]);

          DB::table('partners')->insert([
                'name' => 'Beep',
                'session' => '2019',
                'category' => null,
                'avatar' => '/img/logos/Beep.jpg'
          ]);
          DB::table('partners')->insert([
                'name' => 'Disi',
                'session' => '2019',
                'category' => null,
                'avatar' => '/img/logos/Disi.jpg'
          ]);
            DB::table('partners')->insert([
                  'name' => 'ePorts',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/ePorts.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Ferretería Garcia',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/FerreteriaGarcia.png'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Globals',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Globals.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Informàtica Guerra',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Jabil.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Oficlick',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Oficlick.webp'
            ]);
            DB::table('partners')->insert([
                  'name' => 'PC Serveis',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/PcServeis.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Querol',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/Querol.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Recycling Systems',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/RecyclingSystem.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'Security Pla',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/SecurityPla.jpg'
            ]);
            DB::table('partners')->insert([
                  'name' => 'The Work Shop',
                  'session' => '2019',
                  'category' => null,
                  'avatar' => '/img/logos/TheWorkShop.jpg'
            ]);




        }
      }
}
