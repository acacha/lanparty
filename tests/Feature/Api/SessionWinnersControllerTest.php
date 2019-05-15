<?php

namespace Tests\Feature;

use App\Partner;
use App\Prize;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SessionWinnersControllerTest.
 *
 * @package Tests\Feature
 */
class SessionWinnersControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @group prova
     */
    public function can_remove_all_winners()
    {
        $this->withoutExceptionHandling();
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $oldPrize = Prize::firstOrCreate([
            'name' => 'Samarreta LAN Party',
            'description' => '',
            'notes' => '',
            'value' => 0,
            'partner_id' => Partner::findByName('Ajuntament de Tortosa')->id,
            'multiple' => true,
            'session' => '2018'
        ]);
        $oldPrize->number()->associate(factory(User::class)->create());
        $oldPrize->save();

        //Create some winners
        initialize_prizes();
        $this->assertTrue($count = Prize::all()->count() > 0);

        foreach (Prize::available()->get()->take(5) as $availablePrize) {
            $availablePrize->number()->associate(factory(User::class)->create());
            $availablePrize->save();
        }
        $this->assertEquals(6,Prize::winners()->get()->count());

        $response = $this->json('DELETE','api/v1/' . config('lanparty.session') . '/winners');
        $response->assertSuccessful();


        $this->assertEquals(5, $response->getContent());
        $this->assertEquals(1,Prize::winners()->get()->count());
        $this->assertEquals($count, Prize::all()->count());


    }

    /** @test */
    public function user_cannot_remove_all_winners()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        $response = $this->json('DELETE','api/v1/' . config('lanparty.session') . '/winners');

        $response->assertStatus(403);
    }

}
