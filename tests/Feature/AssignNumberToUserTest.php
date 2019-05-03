<?php

namespace Tests\Feature;

use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AssignNumberToUserTest.
 *
 * @package Tests\Feature
 */
class AssignNumberToUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_assign_number_to_user()
    {
        initialize_roles();
        Number::addNumbers(5,config('lanparty.session'));
        $user = factory(User::class)->create();
        $manager = factory(User::class)->create();

        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/assign_number', [
            'description' => 'Assistència matí divendres',
            'session' => config('lanparty.session')
        ]);
        $response->assertSuccessful();
        $number = json_decode($response->getContent());
        $this->assertSame('Assistència matí divendres', $number->description);
        $this->assertEquals(1, $number->value);
        $this->assertEquals(1, $number->user_id);
        $this->assertCount($user->id,$user->numbers);
        $this->assertSame('Assistència matí divendres', $user->numbers()->first()->description);
        $response->assertJsonStructure([
            'id',
            'value',
            'user_id',
            'created_at',
            'updated_at',
            'user' => [
                'id',
                'name',
                'email',
                'givenName',
                'sn1',
                'sn2',
            ]
        ]);
    }

    /** @test */
    public function cannot_assign_number_to_user_if_no_more_numbers_available()
    {
        initialize_roles();
        $user = factory(User::class)->create();
        $manager = factory(User::class)->create();

        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/assign_number', [
            'description' => 'Assistència matí divendres',
            'session' => config('lanparty.session')
        ]);
        $response->assertStatus(422);
        $this->assertEquals('No queden prou números!',json_decode($response->getContent())->message);
    }

    /** @test */
    public function can_unassign_number_to_user()
    {
        initialize_roles();
        Number::addNumbers(5,config('lanparty.session'));
        $number = Number::first();
        $user = factory(User::class)->create();
        $number->assignUser($user);
        $manager = factory(User::class)->create();

        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $response = $this->json('DELETE','/api/v1/number/' . $number->id .'/assign');
        $response->assertSuccessful();
        $this->assertCount(0, $user->numbers);

    }

    /** @test */
    public function cannnot_unassign_number_to_user_if_not_manager()
    {
        initialize_roles();
        Number::addNumbers(5, config('lanparty.session'));
        $number = Number::first();
        $user = factory(User::class)->create();
        $number->assignUser($user);
        $manager = factory(User::class)->create();
        $this->actingAs($manager,'api');

        $response = $this->json('DELETE','/api/v1/number/' . $number->id .'/assign');
        $response->assertStatus(403);

    }

    /** @test */
    public function cannot_assign_number_to_user_if_not_manager()
    {
        initialize_roles();
        Number::addNumbers(5,config('lanparty.session'));
        $user = factory(User::class)->create();
        $manager = factory(User::class)->create();
        $this->actingAs($manager,'api');

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/assign_number', [
            'description' => 'Assistència matí divendres'
        ]);
        $response->assertStatus(403);
    }
}
