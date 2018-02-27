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
        Ticket::addTickets(100);
        $this->assertCount(100,Ticket::all());
        Ticket::addTickets(100);

        $this->assertCount(200,Ticket::all());
    }

    /** @test */
    public function can_get_first_available_ticket()
    {
        $this->assertSame(Ticket::firstAvailableTicket(), null);
        Ticket::addTickets(5);

        $this->assertEquals(1,Ticket::firstAvailableTicket()->id);

        Factory(User::class)->create()->pay();
        $this->assertEquals(2, Ticket::firstAvailableTicket()->id);
        $ticket = Ticket::firstAvailableTicket();
        Factory(User::class)->create()->pay();
        $this->assertEquals(3, Ticket::firstAvailableTicket()->id);
        $ticket = Ticket::find(1);
        $ticket->update(['user_id' => null]);
        $ticket->save();
        $this->assertEquals(1, Ticket::firstAvailableTicket()->id);
    }
}
