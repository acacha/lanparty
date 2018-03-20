<?php

namespace App\Http\Controllers;

use App\Event;
use App\Group;
use App\Http\Requests\RegisterGroupToEventRequest;
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
    /**
     * Register group to event.
     *
     * @param Request $request
     * @param Event $event
     */
    public function store(RegisterGroupToEventRequest $request, Event $event)
    {
        if ($event->inscription_type_id == 2) abort(422, 'No es pot registrar un grup a un event per a usuaris');

        $group = Group::create([
            'name' => $request->name
        ]);

        $group->avatar = $request->file('avatar')->storeAs(
            'avatars',
            'group_' . $group->id . '_avatar.' . $request->file('avatar')->clientExtension());
        $group->update();

        $group->add(Auth::user());

        collect($request->ids)->each(function($user_id) use ($group) {
            Member::create([
                'user_id' => $user_id,
                'group_id' => $group->id
            ]);
        });

        $event->inscribeGroup($group);
    }
}
