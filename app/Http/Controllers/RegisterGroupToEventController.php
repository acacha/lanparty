<?php

namespace App\Http\Controllers;

use App\Event;
use App\Group;
use App\Member;
use Auth;
use Illuminate\Http\Request;

/**
 * Class RegisterGroupToEventController.
 *
 * @package App\Http\Controllers
 */
class RegisterGroupToEventController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if ($event->inscription_type_id == 2) abort(422, 'No es pot registrar un grup a un event per a usuaris');

        $group = Group::create([
            'name' => $request->name,
            'avatar' => $request->file('avatar')->store('avatars')
            // Same as 'avatar' => $request->avatar->store('avatars', 'local') because local is default filesystem
            // You could use Amazon S3 or others with: 'avatar' => $request->avatar->store('avatars', 's3')
            // specify filename:
//            'avatar' => $request->avatar->storeAs('avatars', $this->getFileName())
        ]);

        $group->add(Auth::user());

//        $i = 2;
        collect($request->ids)->each(function($user_id) use ($group) {
//            $group->members()->save($user,['order' => $i])
            Member::create([
                'user_id' => $user_id,
                'group_id' => $group->id
            ]);
//            $i++;
        });

        $event->inscribeGroup($group);
    }
}
