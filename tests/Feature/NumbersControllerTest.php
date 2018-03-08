<?php

namespace Tests\Feature;

use App\Number;
use App\User;
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
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_fetch_numbers()
    {
        $numbers = factory(Number::class, 5)->create();
        $this->withoutExceptionHandling();
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
}
