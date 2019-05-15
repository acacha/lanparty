<?php

namespace Tests\Feature\Api;

use App\Event;
use App\Prize;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PartnersControllerTest
 *
 * @package Tests\Feature
 */
class PrizesControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function prize_manager_can_show()
    {
        $this->withoutExceptionHandling();
        $this->loginAsManager('api');
        $prize  = factory(Prize::class)->create();
        $response  = $this->json('GET','/api/v1/prizes/'.$prize->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($prize->name, $result->name);
    }
    /** @test */
    public function superadmin_can_show_a_prize()
    {
        $this->loginAsSuperAdmin('api');
        $prize = factory(Prize::class)->create();

        $response = $this->json('GET','/api/v1/prizes/'.$prize->id);
        $result =  json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($prize->name, $result->name);
    }
    /** @test */
    public function regular_user_cannot_show_a_prize()
    {
        $this->login('api');
        $prize =  factory(Prize::class)->create();

        $response  = $this->json('GET','/api/v1/prizes/'.$prize->id);
        $response->assertStatus(403);
    }
    /** @test */
    public function manager_can_delete_prize()
    {
        $this->withoutExceptionHandling();
        $this->loginAsManager('api');
        $prize =  factory(Prize::class)->create();

        $response =  $this->json('DELETE','/api/v1/prizes/'.$prize->id);
        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($result->name, $prize->name);
        $this->assertNull(Prize::find($prize->id));

    }
    /** @test */
    public function superadmin_can_delete_prize()
    {
        $this->loginAsSuperAdmin('api');
        $prize =  factory(Prize::class)->create();

        $response =  $this->json('DELETE','/api/v1/prizes/'.$prize->id);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($result->name,$prize->name);
        $this->assertNull(Prize::find($prize->id));
    }
    /** @test */
    public function regular_user_cannot_delete_prize()
    {
        $this->login('api');
        $prize =  factory(Prize::class)->create();

        $response =  $this->json('DELETE','/api/v1/prizes/'.$prize->id);

        $result = json_decode($response->getContent());
        $response->assertStatus(403);
    }
    /** @test */
    public function cannot_create_prize_whiout_name()
    {
        $this->loginWithPermission('api','prize.store');
        $response = $this->json('POST','/api/v1/prizes/',[
            'name' => ''
        ]);
        $response->assertStatus(422);
    }
    /** @test */
    public function superadmin_can_create_prize()
    {
        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('api');

        $response = $this->json('POST','/api/v1/prizes/',[
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $this->assertNotNull($prize = Prize::find($result->id));
        $this->assertEquals('WII',$result->name);
        $this->assertEquals('bo',$result->description);
        $this->assertEquals('bo',$result->notes);
        $this->assertEquals(1,$result->partner_id);
        $this->assertEquals(1,$result->value);
        $this->assertEquals(true,$result->multiple);

        $this->assertEquals('WII',$prize->name);
        $this->assertEquals('bo',$prize->description);
        $this->assertEquals('bo',$prize->notes);
        $this->assertEquals(1,$prize->partner_id);
        $this->assertEquals(1,$prize->value);
        $this->assertEquals(true,$prize->multiple);
    }
    /** @test */
    public function manager_can_create_prizes()
    {
        $this->loginAsManager('api');

        $response = $this->json('POST','/api/v1/prizes/',[
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $this->assertNotNull($prize = Prize::find($result->id));
        $this->assertEquals('WII',$result->name);
        $this->assertEquals('bo',$result->description);
        $this->assertEquals('bo',$result->notes);
        $this->assertEquals(1,$result->partner_id);
        $this->assertEquals(1,$result->value);
        $this->assertEquals(true,$result->multiple);

        $this->assertEquals('WII',$prize->name);
        $this->assertEquals('bo',$prize->description);
        $this->assertEquals('bo',$prize->notes);
        $this->assertEquals(1,$prize->partner_id);
        $this->assertEquals(1,$prize->value);
        $this->assertEquals(true,$prize->multiple);
    }
    /** @test */
    public function regular_user_cannot_create_prizes()
    {
        $this->login('api');

        $response = $this->json('POST','/api/v1/prizes/',[
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        json_decode($response->getContent());
        $response->assertStatus(403);
    }
    /** @test */
    public function guest_user_cannot_create_prizes()
    {
        $response = $this->json('POST','/api/v1/prizes/',[
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        json_decode($response->getContent());
        $response->assertStatus(401);

    }
    /** @test */
    public function superadmin_can_edit_prize()
    {
        $this->loginAsSuperAdmin('api');

        $this->withoutExceptionHandling();
        $oldPrize =factory(Prize::class)->create([
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $response = $this->json('PUT','/api/v1/prizes/'.$oldPrize->id,[
            'name' => 'PSP',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $result =json_decode($response->getContent());
        $response->assertSuccessful();

        $newPrize =  $oldPrize->refresh();
        $this->assertNotNull($newPrize);
        $this->assertEquals('PSP', $result->name);
    }
    /** @test */
    public function manager_can_edit_prize()
    {
        $this->loginAsManager('api');

        $oldPrize =factory(Prize::class)->create([
            'name' => 'WII',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $response = $this->json('PUT','/api/v1/prizes/'.$oldPrize->id,[
            'name' => 'PSP',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);

        $result =json_decode($response->getContent());
        $response->assertSuccessful();

        $newPrize =  $oldPrize->refresh();
        $this->assertNotNull($newPrize);
        $this->assertEquals('PSP', $result->name);
    }

    /** @test */
    public function cannot_edit_prize_without_name()
    {
        $this->loginAsManager('api');
        $oldPrize = factory(Prize::class)->create();
        $response = $this->json('PUT','/api/v1/prizes/'.$oldPrize->id,[
            'name' => '',
            'description' => 'bo',
            'notes' => 'bo',
            'partner_id' => 1,
            'value' => 1,
            'multiple' => true,
        ]);
        $response->assertStatus(422);
    }
}

