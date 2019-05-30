<?php
/**
 * Created by PhpStorm.
 * User: mirokshi
 * Date: 20/05/19
 * Time: 22:27
 */

namespace Tests\Feature\Web;

use App\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class PartnersAvatarControllerTest extends TestCase
{
  use RefreshDatabase, CanLogin;

  /**
   * @test
   */
  public function upload_avatar()
  {
    //$this->withoutExceptionHandling();
    Storage::fake('public');
    $partner = factory(Partner::class)->create();
    $user = $this->loginAsManager('web');
    $response = $this->post('/avatar/partner', [
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
      'partner_id' => $partner->id
    ]);
    $response->assertRedirect();

    Storage::disk('public')->assertExists($photoUrl = '/partner_avatar/'.$partner->id.'.jpg');
    $partnerFresh = Partner::where('id', $partner->id)->first();

    $this->assertEquals($photoUrl, $partnerFresh->avatar);
    $this->assertNotNull($partnerFresh->avatar);
    $partner = $partner->fresh();
    $this->assertNotNull($partner->avatar);
    $this->assertEquals($photoUrl, $partner->avatar);
  }

  /**
   * @test
   */
  public function show_partner_default_avatar()
  {
    $partner = factory(Partner::class)->create();
    $user = $this->loginAsManager('web');
    $this->withoutExceptionHandling();
    initialize_partner_default_avatar();
    $response = $this->get('/avatar/partner/'.$partner->id);
    $response->assertSuccessful();
    $this->assertEquals(storage_path('app/public/'.Partner::DEFAULT_AVATAR_PATH), $response->baseResponse->getFile()->getPathName());
    $response->assertSuccessful();
  }

  /** @test */
  public function show_partner_avatar()
  {
    $this->withoutExceptionHandling();
    $partner = factory(Partner::class)->create();
    //login
    $user = $this->loginAsManager('web');
    $response = $this->post('/avatar/partner', [
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
      'partner_id' => $partner->id
    ]);

    $response->assertRedirect();
    $partner = $partner->fresh();
    $response = $this->get('/avatar/partner/'.$partner->id);
    $response->assertSuccessful();
    Storage::disk('public')->assertExists($partner->avatar);

    $this->assertEquals(storage_path('app/public/'.$partner->avatar), $response->baseResponse->getFile()->getPathName());
    $this->assertFileEquals(storage_path('app/public/'.$partner->avatar), $response->baseResponse->getFile()->getPathName());
    $response->assertSuccessful();
  }
}
