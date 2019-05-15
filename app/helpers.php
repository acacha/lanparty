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
    function initialize_prizes($session = null)
    {
        if (is_null($session)) $session = config('lanparty.session');
        Prize::firstOrCreate([
            'name' => 'Samarreta LAN Party',
            'description' => '',
            'notes' => '',
            'value' => 0,
            'partner_id' => Partner::findByName('Ajuntament de Tortosa')->id,
            'multiple' => true,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'ARCADE STICK NETWAY GAMING ARCADE FIGHTER PS3/PC',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'ARCADE STICK NETWAY GAMING ARCADE FIGHTER PS3/PC',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => '1  GAMEPAD NETWAY GAMING EVO PS3/PC/ANDROID WIRELESS',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('Beep')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'TECLAT KROSS KROM',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 7400,
            'partner_id' => Partner::findByName('Beep')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Volant i pedals',
            'description' => '',
            'notes' => '1r classificat Counter Strike',
            'value' => 5999,
            'partner_id' => Partner::findByName('Beep')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Hoverboard Airstream All Road',
            'description' => '',
            'notes' => '1r classificat concurs Hardware',
            'value' => 14620,
            'partner_id' => Partner::findByName('Beep')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'DOC Hoverboard Off Road',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 24775,
            'partner_id' => Partner::findByName('The Workshop')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Samsung 860 EVO Basic SSD 500GB SATA3 + Curs Visual Basic',
            'description' => '',
            'notes' => '1r classificat concurs de programació',
            'value' => 23000,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Curs Visual Bàsic',
            'description' => '',
            'notes' => '2n classificat de programació',
            'value' => 12550,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999, // Ja assignat,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Curs Visual Bàsic',
            'description' => '',
            'notes' => '3r classificat de programació',
            'value' => 12550,
            'partner_id' => Partner::findByName('DISI')->id,
            'user_id' => 999999,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Tablet GT10W3 Tablet 3Go, RAM 2GB 10" W10 IPS 1280x800 32GB" (Windows 8.1)',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 18700,
            'partner_id' => Partner::findByName('AGI')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Monitor de 23 polzades',
            'description' => '',
            'notes' => '1r classificat Ae of Empires 2 HD',
            'value' => 12900,
            'partner_id' => Partner::findByName('PC Serveis')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => '1 router domèstic TP-Link Archer C2 1',
            'description' => '',
            'notes' => '2n classificat concurs programació',
            'value' => 3999,
            'partner_id' => Partner::findByName('EPorts')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => '1 router domèstic TP-Link Archer C2 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 3999,
            'partner_id' => Partner::findByName('EPorts')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Discs dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats League of Legends',
            'value' => 7500,
            'partner_id' => Partner::findByName('SecurityPla')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Discs dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats Counter Strike',
            'value' => 7500,
            'partner_id' => Partner::findByName('SecurityPla')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Torre de música amb bluetooth PROSTIMA SAM',
            'description' => '',
            'notes' => 'Guanyador concurs cartell LAN Party',
            'value' => 7500,
            'partner_id' => Partner::findByName('Altercom 21')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Dron Parrot Ardrone2.0 Elite Edition',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 14900,
            'partner_id' => Partner::findByName('Globals')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Teclat Trust AVONN Gaming',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2999,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Ratolí ORNA 3200dpi OPTICAL',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2695,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Auriculars MARS GAMING MH2',
            'description' => '',
            'notes' => '2n classificat Age Of Empires 2',
            'value' => 1575,
            'partner_id' => Partner::findByName('Ferreteria Garcia')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Teclat Gaming  Razer Ornata Chroma',
            'description' => '',
            'notes' => '1r classificat Counter Strike',
            'value' => 8999,
            'partner_id' => Partner::findByName('Jabil')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Kit Tacens Mars Gaming MACP1(teclat, auriculars, ratolí i alfombreta)',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2095,
            'partner_id' => Partner::findByName('Querol')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Auricular Energy System energy audio headphones bluetooth',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2490,
            'partner_id' => Partner::findByName('Querol')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'MiniDrone 3GO Maverick 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 2300,
            'partner_id' => Partner::findByName('Querol')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Xassis ATX',
            'description' => '',
            'notes' => '2n classificat Concurs de hardware',
            'value' => 6000,
            'partner_id' => Partner::findByName('Electrotic')->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => '1 funda consola, 1 ratolí i alfombreta 1',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 1000,
            'partner_id' => Partner::findByName('Electrotic')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => '1 funda consola, 1 ratolí i alfombreta 2',
            'description' => '',
            'notes' => 'Sorteig dissabte',
            'value' => 1000,
            'partner_id' => Partner::findByName('Electrotic')->id,
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'Disc dur SSD Toshiba OCZ TR2000 de 240 GB',
            'description' => '',
            'notes' => '1rs classificats League of Legends',
            'value' => 6500,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'SMARTWATCH NETWAY TEMPUS PLUS',
            'description' => '',
            'notes' => '1r classificats Overwatch (6)+ 2 sorteig dissabte',
            'value' => 3000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'MEMORIA 16 GB REMOVIBLE KINGSTON USB 3.0 DT G4',
            'description' => '',
            'notes' => '2n classificats Overwatch (6)+ League of Legends(5)+ Counter Strike(3)',
            'value' => 1000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
        ]);

        Prize::firstOrCreate([
            'name' => 'MEMORIA 16 GB REMOVIBLE KINGSTON USB 3.0 DT G4',
            'description' => '',
            'notes' => '2n classificats Overwatch (6)+ League of Legends(5)+ Counter Strike(3)',
            'value' => 1000,
            'partner_id' => Partner::findByName("Departament d'informàtica")->id,
            'user_id' => 999999, // Ja assignat
            'session' => $session
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
            'sessions' => config('lanparty.sessions'),
            'inscription_price' => config('lanparty.inscription_price'),
            'event_inscription_price' => config('lanparty.event_inscription_price')
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
            'managers.invitation.send',
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
            'numbers.destroy',
            'session.winners.destroy',
            'prize.show',
            'prize.store',
            'prize.destroy',
            'prize.update',
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

if (! function_exists('map_collection')) {
    function map_simple_collection($collection)
    {
        return $collection->map(function($item) {
            return $item->mapSimple();
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
                DB::table('partners')->where('session', '2019')->delete();
                Partner::firstOrCreate([
                    'name' => 'Ajuntament de Tortosa',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/Ajuntament.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'Dep. Informatica Institut de l\'Ebre',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/iesEbre.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'AGI(EbreSoft Consulting)',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/AGI.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'Altercom21',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/Altercom.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'BEEP',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/BEEP.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'Alonso - Delta Stocks',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/Alonso.jpg'
                ]);
                Partner::firstOrCreate([
                    'name' => 'Disi',
                    'session' => '2019',
                    'category' => null,
                    'avatar' => '/img/logos/Disi.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'ePorts',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/ePorts.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Fusteria Almendros',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Almendros.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Globals',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Globals.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Guerra Informàtica',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Guerra.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Jabil',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Jabil.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'PC Serveis',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/PcServeis.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Querol',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Querol.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Recycling Systems',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/RecyclingSystem.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Security Pla',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/SecurityPla.jpg'
                ]);
                Partner::firstOrCreate([
                      'name' => 'Bar de Tomàs',
                      'session' => '2019',
                      'category' => null,
                      'avatar' => '/img/logos/Tomas.jpg'
                ]);
            }
          }


          if (!function_exists('create_prizes_2019')) {
              function create_prizes_2019() {
                    $prizes2019 = [
                        [
                          'partner' => 'Ajuntament de Tortosa',
                          'items' => [
                              [ 'name' => 'Samarretes Lan Party',
                                'description' => '',
                                'notes' => '',
                                'value' => 79860,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Dep. Informatica Institut de l\'Ebre',
                          'items' => [
                              [ 'name' => '6x Disc dur extern 1TB',
                                'description' => '',
                                'notes' => 'Guanyador Overwatch',
                                'value' => 5500,
                                'user_id' => 9999
                              ],
                              [ 'name' => '5x Teclat gaming',
                                'description' => '',
                                'notes' => 'Guanyador LOL',
                                'value' => 7000,
                                'user_id' => 9999
                              ],
                              [ 'name' => '6x Disc dur extern 1TB',
                                'description' => '',
                                'notes' => 'Guanyador Overwatch',
                                'value' => 5500,
                                'user_id' => 9999
                              ],
                              [ 'name' => '5x Webcams',
                                'description' => '',
                                'notes' => '2n Classificat LOL',
                                'value' => 1300,
                                'user_id' => 9999
                              ],
                              [ 'name' => '3x Auriculars Sport',
                                'description' => '',
                                'notes' => '2n Classificat FIFA i CounterStrike',
                                'value' => 1100,
                                'user_id' => 9999
                              ],
                              [ 'name' => '6x Alfombretes Gaming',
                                'description' => '',
                                'notes' => '2n Classificat OverWatch i Ciberseguretat',
                                'value' => 1100,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'AGI(EbreSoft Consulting)',
                          'items' => [
                              [ 'name' => '3 Discs durs SSD Kingston 480 GB',
                                'description' => '',
                                'notes' => 'Guanyador Campionat Ciberseguretat',
                                'value' => 21900,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Altercom21',
                          'items' => [
                              [ 'name' => 'Telèfon Mòbil Xiaomi RediMi Go',
                                'description' => '',
                                'notes' => 'Guanyador Campionat Programació',
                                'value' => 7500,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'BEEP',
                          'items' => [
                              [ 'name' => 'Cadira Mars Gaming MGC0BR i 6 funkos Star Wars',
                                'description' => '',
                                'notes' => '',
                                'value' => 16000,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Alonso - Delta Stocks',
                          'items' => [
                              [ 'name' => 'Monitor Gaming',
                                'description' => '',
                                'notes' => '',
                                'value' => 16000
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Disi',
                          'items' => [
                              [ 'name' => '1 Disc dur SSD 500GB',
                                'description' => '',
                                'notes' => 'Guanyador Cartell LanParty',
                                'value' => 7300,
                                'user_id' => 9999
                              ],
                              [ 'name' => '1 Disc dur SSD 500GB',
                                'description' => '',
                                'notes' => 'Guanyador Sorteig FaceBook',
                                'value' => 7300,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'ePorts',
                          'items' => [
                              [ 'name' => '3 Discs durs SSD Western Digital 500GB',
                                'description' => '',
                                'notes' => 'Guanyadors CounterStrike',
                                'value' => 20000,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Fusteria Almendros',
                          'items' => [
                              [ 'name' => 'Teclat Gaming Mecànic Titan Rodex',
                                'description' => '',
                                'notes' => '',
                                'value' => 4999,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Globals',
                          'items' => [
                              [ 'name' => 'Auriculars Gaming Logitech G430 Gaming Surround Sound 7.1',
                                'description' => '',
                                'notes' => '',
                                'value' => 5000,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Guerra Informàtica',
                          'items' => [
                              [ 'name' => 'Impresora laser wifi Kyocera',
                                'description' => '',
                                'notes' => '',
                                'value' => 60000,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Jabil',
                          'items' => [
                              [ 'name' => 'Teclat Gaming Newskill Hanshi Spectrum Mecànic RGB Kailh ',
                                'description' => '',
                                'notes' => 'Guanyador FIFA',
                                'value' => 8000,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'PC Serveis',
                          'items' => [
                              [ 'name' => 'Monitor 27" Acer KA Series',
                                'description' => '',
                                'notes' => '',
                                'value' => 17700,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Querol',
                          'items' => [
                              [ 'name' => 'Impressora Canon TS3150',
                                'description' => '',
                                'notes' => '',
                                'value' => 4100,
                              ],
                              [ 'name' => 'Auriculars Pioneer SE-MJ503T-K',
                                'description' => '',
                                'notes' => '',
                                'value' => 1500,
                              ],
                              [ 'name' => 'Mars Gaming MRCP1 Combo 4x1 Tec+Rat+Alf+Auric',
                                'description' => '',
                                'notes' => '',
                                'value' => 2200,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Recycling Systems',
                          'items' => [
                              [ 'name' => 'Regals diversos',
                                'description' => '',
                                'notes' => '',
                                'value' => 9000,
                              ],
                              [ 'name' => 'Auriculars Enery Running',
                                'description' => '',
                                'notes' => '2n Classsificat Campionat Programació',
                                'value' => 1200,
                                'user_id' => 9999
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Security Pla',
                          'items' => [
                              [ 'name' => 'Disc dur WD SSD 500GB ',
                                'description' => '',
                                'notes' => '',
                                'value' => 6500,
                              ]
                          ]
                        ],
                        [
                          'partner' => 'Bar de Tomàs',
                          'items' => [
                              [ 'name' => '10 esmorzars',
                                'description' => '',
                                'notes' => '',
                                'value' => 6000,
                              ]
                          ]
                        ]
                    ];

                    DB::table('prizes')->where('session', '2019')->delete();
                    foreach ($prizes2019 as $prize) {
                      $partnerId = Partner::where('name', $prize['partner'])->where('session','2019' )->first()->id;
                      foreach ($prize['items'] as $item) {
                          $data = [
                              'name' => $item['name'],
                              'description' => $item['description'],
                              'notes' => $item['notes'],
                              'value' => $item['value'],
                              'partner_id' => $partnerId,
                              'session' => '2019'
                          ];
                          if (array_key_exists('user_id',$item)) {
                              $data['user_id'] = $item['user_id'];
                          }
                        Prize::firstOrCreate($data);
                      }
                    }

              }
          }
}

if (!function_exists('initialize_event_default_image')) {
    function initialize_event_default_image()
    {
        if (!Storage::disk('local')->exists('public/event_images/default.png') && File::exists(base_path('tests/__fixtures__/avatar.png')) ){
            Storage::disk('local')->put(
                'public/event_images/default.png',
                File::get(base_path('tests/__fixtures__/avatar.png'))
            );
        }
    }
}




// PREMIS 2018:
//INSERT INTO `prizes` VALUES
//(1,'2018','Samarreta LAN Party','','',0,1,NULL,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',1),
//(2,'2018','ARCADE STICK NETWAY GAMING ARCADE FIGHTER PS3/PC','','Sorteig dissabte',3999,2,NULL,222,'2018-05-11 12:06:12','2018-05-12 17:57:55',0),
//(3,'2018','1  GAMEPAD NETWAY GAMING EVO PS3/PC/ANDROID WIRELESS','','Sorteig dissabte',3999,2,NULL,208,'2018-05-11 12:06:12','2018-05-12 17:52:28',0),
//(4,'2018','TECLAT KROSS KROM','','Sorteig dissabte',7400,2,NULL,64,'2018-05-11 12:06:12','2018-05-12 17:53:36',0),
//(5,'2018','Volant i pedals','','1r classificat Counter Strike',5999,2,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(6,'2018','Hoverboard Airstream All Road','','Sorteig dissabte',14620,2,NULL,209,'2018-05-11 12:06:12','2018-05-12 18:05:33',0),
//(7,'2018','DOC Hoverboard Off Road','','1r classificat concurs Hardware',24775,3,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(8,'2018','Samsung 860 EVO Basic SSD 500GB SATA3 + Curs Visual Basic','','1r classificat concurs de programació',23000,5,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(9,'2018','Curs Visual Bàsic','','2n classificat de programació',12550,5,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(10,'2018','Curs Visual Bàsic','','3r classificat de programació',12550,5,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(11,'2018','Tablet GT10W3 Tablet 3Go, RAM 2GB 10\" W10 IPS 1280x800 32GB\" (Windows 8.1)','','Sorteig dissabte',18700,6,NULL,269,'2018-05-11 12:06:12','2018-05-12 18:03:37',0),
//(12,'2018','Monitor de 23 polzades','','1r classificat Ae of Empires 2 HD',12900,4,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(13,'2018','1 router domèstic TP-Link Archer C2','','2n classificat concurs programació',3999,7,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(14,'2018','1 router domèstic TP-Link Archer C2','','Sorteig dissabte',3999,7,NULL,203,'2018-05-11 12:06:12','2018-05-12 17:54:34',0),
//(15,'2018','Discs dur SSD Toshiba OCZ TR2000 de 240 GB','','1rs classificats League of Legends',7500,8,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(16,'2018','Discs dur SSD Toshiba OCZ TR2000 de 240 GB','','1rs classificats Counter Strike',7500,8,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(17,'2018','Torre de música amb bluetooth PROSTIMA SAM','','Guanyador concurs cartell LAN Party',7500,9,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(18,'2018','Dron Parrot Ardrone2.0 Elite Edition','','Sorteig dissabte',14900,10,NULL,7,'2018-05-11 12:06:12','2018-05-12 18:02:56',0),
//(19,'2018','Teclat Trust AVONN Gaming','','Sorteig dissabte',2999,11,NULL,37,'2018-05-11 12:06:12','2018-05-12 17:56:01',0),
//(20,'2018','Ratolí ORNA 3200dpi OPTICAL','','Sorteig dissabte',2695,11,NULL,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(21,'2018','Auriculars MARS GAMING MH2','','2n classificat Age Of Empires 2',1575,11,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(22,'2018','Teclat Gaming  Razer Ornata Chroma','','1r classificat Counter Strike',8999,12,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(23,'2018','Kit Tacens Mars Gaming MACP1(teclat, auriculars, ratolí i alfombreta)','','Sorteig dissabte',2095,13,NULL,115,'2018-05-11 12:06:12','2018-05-12 17:56:48',0),
//(24,'2018','Auricular Energy System energy audio headphones bluetooth','','Sorteig dissabte',2490,13,NULL,95,'2018-05-11 12:06:12','2018-05-12 17:55:22',0),
//(25,'2018','MiniDrone 3GO Maverick 2','','Sorteig dissabte',2300,13,NULL,72,'2018-05-11 12:06:12','2018-05-12 17:58:35',0),
//(26,'2018','Xassis ATX','','2n classificat Concurs de hardware',6000,14,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(27,'2018','1 funda consola, 1 ratolí i alfombreta','','Sorteig dissabte',1000,14,NULL,296,'2018-05-11 12:06:12','2018-05-12 17:50:10',0),
//(28,'2018','Disc dur SSD Toshiba OCZ TR2000 de 240 GB','','1rs classificats League of Legends',6500,15,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(29,'2018','SMARTWATCH NETWAY TEMPUS PLUS','','1r classificats Overwatch (6)+ 2 sorteig dissabte',3000,15,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0),
//(30,'2018','MEMORIA 16 GB REMOVIBLE KINGSTON USB 3.0 DT G4','','2n classificats Overwatch (6)+ League of Legends(5)+ Counter Strike(3)',1000,15,9999,NULL,'2018-05-11 12:06:12','2018-05-11 12:06:12',0);
