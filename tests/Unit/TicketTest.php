<?php

namespace Tests\Unit;

use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TicketTest.
 *
 * @package Tests\Unit
 */
class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tickets_can_be_added()
    {
        Ticket::addTickets(100,config('lanparty.session'));
        $this->assertCount(100,Ticket::all());
        Ticket::addTickets(100,config('lanparty.session'));

        $this->assertCount(200,$tickets = Ticket::all());
        $this->assertEquals(config('lanparty.session'),$tickets[0]->session);
    }

    /** @test */
    public function can_get_first_available_ticket()
    {
        $this->assertSame(Ticket::firstAvailableTicket(config('lanparty.session')), null);
        Ticket::addTickets(5,config('lanparty.session'));

        $this->assertEquals(1,Ticket::firstAvailableTicket(config('lanparty.session'))->id);

        Factory(User::class)->create()->pay(config('lanparty.session'));
        $this->assertEquals(2, Ticket::firstAvailableTicket(config('lanparty.session'))->id);
        Factory(User::class)->create()->pay(config('lanparty.session'));
        $this->assertEquals(3, Ticket::firstAvailableTicket(config('lanparty.session'))->id);
        $ticket = Ticket::find(1);
        $ticket->update(['user_id' => null]);
        $ticket->save();
        $this->assertEquals(1, Ticket::firstAvailableTicket(config('lanparty.session'))->id);
    }
}
