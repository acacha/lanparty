<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotEnoughTicketsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\TicketsDestroy;
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

    public function delete(TicketsDestroy $request)
    {
        try {
            Ticket::removeTickets($request->quantity,$request->session);
        } catch (NotEnoughTicketsException $e) {
            abort('422',"S'han eliminat tots els tickets disponibles");
        }
    }
}
