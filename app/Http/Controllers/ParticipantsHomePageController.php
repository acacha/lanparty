<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\EventResourceForHomePage;
use App\Http\Resources\UsersForHomePageResource;
use App\User;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ParticipantsHomePageController.
 *
 * @package App\Http\Controllers
 */
class ParticipantsHomePageController extends Controller
{
    /**
     * Main view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = collect(UsersForHomePageResource::collection(User::all()));
        $events = EventResourceForHomePage::collection(Event::published()->with(['users','groups','groups.members','registrations'])->get());
        return view('home', [
            'events' => $events->collection,
            'user' => Auth::user(),
            'users' => $users,
        ]);
    }
}
