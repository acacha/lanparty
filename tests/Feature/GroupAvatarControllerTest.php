<?php

namespace Tests\Feature;

use App\Group;
use App\User;
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
}
