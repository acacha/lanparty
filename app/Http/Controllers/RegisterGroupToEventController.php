<?php

namespace App\Http\Controllers;

use App\Event;
use App\Group;
use App\Http\Requests\RegisterGroupToEventRequest;
use App\Http\Requests\UnregisterGroup;
use App\Http\Resources\GroupResource;
use App\Member;
use App\User;
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

        $ids = is_array($request->ids) ? $request->ids : json_decode($request->ids);
        collect($ids)->each(function($user_id) use ($group) {
            $group->add(User::findOrFail($user_id));
        });

        $event->inscribeGroup($group);

        return new GroupResource($group->fresh());
    }

    /**
     * Unregister group to event.
     *
     * @param Request $request
     * @param Event $event
     * @param Group $group
     * @return Group
     */
    public function destroy(UnregisterGroup $request, Event $event, Group $group)
    {
        $event->unregisterGroup($group);
        $group->delete();
        return $group;
    }
}
