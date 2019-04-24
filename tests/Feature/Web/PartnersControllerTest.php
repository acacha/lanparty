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

class PartnersControllerTest extends TestCase
{
  use RefreshDatabase, CanLogin;


    /** @test */
    public function manager_can_see_partners_module()
    {
        $this->loginAsManager('web');
        $response = $this->json('GET','/manage/partners');
        $response->assertSuccessful();
        $response->assertViewIs('manage.partners.index');
        $response->assertViewHas('partners');
    }

    /** @test */
    public function superadmin_can_see_partners_module()
    {
      $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('web');
        $response = $this->json('GET','/manage/partners');
        $response->assertSuccessful();
        $response->assertViewIs('manage.partners.index');
        $response->assertViewHas('partners');
    }

    /** @test */
    public function regular_user_cannot_see_partners_module()
    {
        $this->login('web');
        $response = $this->json('GET','/manage/partners');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_see_partners_module()
    {
        $response = $this->json('GET','/manage/partners');
        $response->assertStatus(401);
    }


}
