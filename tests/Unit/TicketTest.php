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
        Ticket::addTickets(100,'2018');
        $this->assertCount(100,Ticket::all());
        Ticket::addTickets(100,'2018');

        $this->assertCount(200,Ticket::all());
    }

    /** @test */
    public function can_get_first_available_ticket()
    {
        $this->assertSame(Ticket::firstAvailableTicket('2018'), null);
        Ticket::addTickets(5,'2018');

        $this->assertEquals(1,Ticket::firstAvailableTicket('2018')->id);

        Factory(User::class)->create()->pay('2018');
        $this->assertEquals(2, Ticket::firstAvailableTicket('2018')->id);
        Factory(User::class)->create()->pay('2018');
        $this->assertEquals(3, Ticket::firstAvailableTicket('2018')->id);
        $ticket = Ticket::find(1);
        $ticket->update(['user_id' => null]);
        $ticket->save();
        $this->assertEquals(1, Ticket::firstAvailableTicket('2018')->id);
    }
}
