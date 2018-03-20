<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class GroupAvatarControllerTest.
 *
 * @package Tests\Feature
 */
class GroupAvatarControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_show_group_avatar()
    {
        Storage::fake('local');

        Storage::disk('local')->put(
            'avatars/avatar.png',
            file_get_contents(base_path('tests/__fixtures__/avatar.png'))
        );

        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit',
            'avatar' => 'avatars/avatar.png'
        ]);

        $user = factory(User::class)->create();
        $this->actingAs($user);


        $response = $this->get('/group/' . $group->id . '/avatar');
        $response->assertSuccessful();

        $showedImage = file_get_contents($response->baseResponse->getFile()->getPathName());
        $originalImage = file_get_contents(base_path('tests/__fixtures__/avatar.png'));
        $this->assertEquals($showedImage, $originalImage);
    }

    /** @test */
    public function show_group_avatar_placeholder_for_group_without_avatar()
    {
        $this->withoutExceptionHandling();
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/group/' . $group->id . '/avatar');
        $response->assertSuccessful();

        $showedImage = file_get_contents($response->baseResponse->getFile()->getPathName());
        $originalImage = file_get_contents(base_path('tests/__fixtures__/groupPlaceholder.jpg'));
        $this->assertEquals($showedImage, $originalImage);
    }

    /** @test */
    public function cannot_change_group_avatar_of_unexisting_group()
    {
//        Route::post('/group/1/avatar','GroupAvatarController@store');

        Storage::fake('avatars');

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->post('/group/1/avatar', [
            'avatar' => UploadedFile::fake()->image('avatar2.png')
        ]);
//        $response->dump();

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_change_group_avatar()
    {
        $this->withoutExceptionHandling();

        Storage::fake();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        Storage::put(
            'avatars/avatar.png',
            file_get_contents(base_path('tests/__fixtures__/avatar.png'))
        );

        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit',
            'avatar' => 'avatars/avatar.png'
        ]);

        $response = $this->post('/group/' . $group->id . '/avatar',[
            'avatar' => UploadedFile::fake()->image('avatar2.png')
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => 1,
            'name'=> 'Smells Like Team Spirit',
            'avatar' => 'avatars/1_smells_like_team_spirit.png'
        ]);

        $group = $group->fresh();

        $this->assertEquals($group->avatar, 'avatars/1_smells_like_team_spirit.png');

        Storage::assertExists('avatars/1_smells_like_team_spirit.png');
        Storage::assertMissing('avatars/avatar.png');
    }
}
