<?php
/**
 * Created by PhpStorm.
 * User: mirokshi
 * Date: 27/03/19
 * Time: 17:03
 */

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class PremisControllerTest extends TestCase
{
  use RefreshDatabase, CanLogin;

  /**
   * @test
   */
  public function manager_can_see_premis_module()
  {
    $this->withoutExceptionHandling();
    $this->loginAsSuperAdmin('web');
    $response = $this->json('GET','/manage/premis');
    $response->assertSuccessful();
    $response->assertViewIs('manage.premis.index');
    $response->assertViewHas('premis');
  }
}
