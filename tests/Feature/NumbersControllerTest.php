<?php

namespace Tests\Feature;

use App\Number;
use App\User;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NumbersControllerTest.
 *
 * @package Tests\Feature
 */
class NumbersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function logged_user_can_fetch_numbers()
    {
        $numbers = factory(Number::class, 5)->create();
        $user = factory(User::class)->create([
            'name' => 'Acacha',
            'givenName' => 'Sergi',
            'sn1' => 'Tur',
            'sn2' => 'Badenas',
        ]);
        $numbers[0]->assignUser($user);
        $this->actingAs($user,'api');
        $response = $this->json('GET','/api/v1/numbers');
        $response->assertSuccessful();
        $this->assertCount(5,json_decode($response->getContent()));
        $response->assertJsonStructure([[
            'id',
            'value',
            'description',
            'created_at',
            'updated_at',
        ]]);
        $numbers = json_decode($response->getContent());

        $this->assertEquals('Tur',$numbers[0]->user->sn1);
        $this->assertEquals('Badenas',$numbers[0]->user->sn2);
        $this->assertEquals('Sergi',$numbers[0]->user->givenName);
    }

    /** @test */
    public function manager_can_add_numbers()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => $session = config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertSuccessful();
        $this->assertCount(3, $numbers = Number::numbers());
        $this->assertEquals($session,$numbers[0]['session']);
        $this->assertEquals(1,$numbers[0]['value']);
        $this->assertNull($numbers[0]['user_id']);
        $this->assertEquals($session,$numbers[1]['session']);
        $this->assertEquals(2,$numbers[1]['value']);
        $this->assertNull($numbers[1]['user_id']);
        $this->assertEquals($session,$numbers[2]['session']);
        $this->assertEquals(3,$numbers[2]['value']);
        $this->assertNull($numbers[2]['user_id']);
    }

    /** @test */
    public function manager_can_add_numbers_to_new_session_with_already_existing_session()
    {
        $this->withoutExceptionHandling();
        Number::addNumbers(10,'2018');

        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => $session = config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertSuccessful();
        $this->assertCount(13, $allNumbers = Number::numbers());
        $this->assertCount(3, $numbers = Number::currentNumbers());

        // NUMBERS 2018
        $this->assertEquals('2018',$allNumbers[0]['session']);
        $this->assertEquals(1,$allNumbers[0]['value']);
        $this->assertNull($allNumbers[0]['user_id']);
        $this->assertEquals('2018',$allNumbers[1]['session']);
        $this->assertEquals(2,$allNumbers[1]['value']);
        $this->assertNull($allNumbers[1]['user_id']);
        $this->assertEquals('2018',$allNumbers[2]['session']);
        $this->assertEquals(3,$allNumbers[2]['value']);
        $this->assertNull($allNumbers[2]['user_id']);


        // NUMBERS 2019
        $this->assertEquals(config('lanparty.session'),$allNumbers[10]['session']);
        $this->assertEquals(1,$allNumbers[10]['value']);
        $this->assertNull($allNumbers[10]['user_id']);
        $this->assertEquals(config('lanparty.session'),$allNumbers[11]['session']);
        $this->assertEquals(2,$allNumbers[11]['value']);
        $this->assertNull($allNumbers[11]['user_id']);
        $this->assertEquals(config('lanparty.session'),$allNumbers[12]['session']);
        $this->assertEquals(3,$allNumbers[12]['value']);
        $this->assertNull($allNumbers[12]['user_id']);

        $this->assertEquals(config('lanparty.session'),$numbers[0]['session']);
        $this->assertEquals(1,$numbers[0]['value']);
        $this->assertNull($numbers[0]['user_id']);
        $this->assertEquals(config('lanparty.session'),$numbers[1]['session']);
        $this->assertEquals(2,$numbers[1]['value']);
        $this->assertNull($numbers[1]['user_id']);
        $this->assertEquals(config('lanparty.session'),$numbers[2]['session']);
        $this->assertEquals(3,$numbers[2]['value']);
        $this->assertNull($numbers[2]['user_id']);

    }

    /** @test */
    public function cannot_add_zero_numbers()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => config('lanparty.session'),
            'quantity' => 0
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function manager_can_add_numbers_validation()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function regular_user_cannot_add_numbers()
    {
        $this->login('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_add_numbers()
    {
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertStatus(401);
    }

    /** @test */
    public function manager_can_remove_numbers()
    {
        Number::addNumbers(4,config('lanparty.session'));
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers/remove', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertSuccessful();
        $this->assertCount(1, $numbers = Number::numbers());
        $this->assertEquals(config('lanparty.session'),$numbers[0]['session']);
        $this->assertNull($numbers[0]['user_id']);
    }

    /** @test */
    function manager_cannot_remove_more_numbers_than_available()
    {
        Number::addNumbers(3,config('lanparty.session'));
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers/remove', [
            'session' => config('lanparty.session'),
            'quantity' => 4
        ]);
        $response->assertStatus(422);
        $result = json_decode($response->getContent());
        $this->assertEquals('S\'han eliminat tots els números disponibles', $result->message);
        $this->assertCount(0, $numbers = Number::numbers());
    }

    /** @test */
    public function manager_can_remove_numbers_validation()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers/remove', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function nobody_can_perform_actions_on_deleted_sessions() {
        Number::addNumbers(4,'2018');
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers/remove', [
            'session' => '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/numbers/remove', [
            'session' => '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => $session = '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/numbers', [
            'session' => $session = '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

    }

}
