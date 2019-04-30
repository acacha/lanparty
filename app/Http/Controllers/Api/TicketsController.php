<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\TicketsStore;
use App\Ticket;

/**
 * Class TicketsController.
 *
 * @package App\Http\Controllers
 */
class TicketsController extends Controller
{
    /**
     * Get all numbers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return Ticket::tickets();
    }

    public function store(TicketsStore $request)
    {
        Ticket::addTickets($request->quantity,$request->session);
    }
}
