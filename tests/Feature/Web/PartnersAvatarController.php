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

class PartnersAvatarController extends TestCase
{
  use RefreshDatabase, CanLogin;

  /**
   * @test
   */
  public function upload_avatar()
  {
    Storage::fake('local');

    $this->login();
    $partner = Partner::find(1);
    $response = $this->post('/avatar',[
      'phote' => UploadedFile::fake()->image('avatar.png')
    ]);
    $response->assertRedirect();

    Storage::disk('local')->assertExists($photoUrl = 'avatars/'.$partner->id.'.jpg');
  }
}
