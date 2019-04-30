<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\ManagePartipantsRequest;
use App\Http\Resources\EventResourceForHomePage;
use App\Http\Resources\NumberWithUserResource;
use App\Number;
use App\Ticket;
use App\User;
use Auth;

/**
 * Class ManageParticipantsController.
 *
 * @package App\Http\Controllers
 */
class ManageParticipantsController extends Controller
{
    /**
     * Manage participants.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManagePartipantsRequest $request)
    {
        $events = collect(EventResourceForHomePage::collection(Event::published()->get())->resolve());
        $users = map_collection(User::with(['ticket','events','roles','numbers'])->withCount('ticket')->get());
        $numbers = collect(NumberWithUserResource::collection(Number::with(['user'])->get())->resolve());
        $tickets = Ticket::tickets();
        return view('manage.participants', [
            'user' => Auth::user(),
            'users' => $users,
            'numbers' => $numbers,
            'tickets' => $tickets,
            'events' => $events,
        ]);
    }
}
