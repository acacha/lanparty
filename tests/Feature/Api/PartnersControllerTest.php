<?php

namespace Tests\Feature\Api;

use App\Event;
use App\Partner;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PartnersControllerTest
 *
 * @package Tests\Feature
 */
class PartnersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    //*****************************SHOW********************************//
    /** @test */
  public function partner_manager_can_show()
  {
    $this->withoutExceptionHandling();
    $this->loginAsManager('api');
    $partner  = factory(Partner::class)->create();

    $response  = $this->json('GET','/api/v1/partners/'.$partner->id);

    $result = json_decode($response->getContent());
    $response->assertSuccessful();
    $this->assertEquals($partner->name, $result->name);
    $this->assertEquals($partner->category,$result->category );

    }

    /** @test */
  public function superadmin_can_show_a_partners()
  {
    $this->loginAsSuperAdmin('api');
    $partner = factory(Partner::class)->create();

    $response = $this->json('GET','/api/v1/partners/'.$partner->id);
    $result =  json_decode($response->getContent());

    $response->assertSuccessful();
    $this->assertEquals($partner->name, $result->name);
    $this->assertEquals($partner->category, $result->category);
    }

    /** @test */
  public function regular_user_cannot_show_a_partner()
  {
    $this->login('api');
    $partner =  factory(Partner::class)->create();

    $response  = $this->json('GET','/api/v1/partners/'.$partner->id);
    $response->assertStatus(403);
    }

    /** @test */
  public function guest_user_cannot_show_a_partner()
  {
    $partner = factory(Partner::class)->create();

    $response = $this->json('GET','/api/v1/partners/'.$partner->id);
    $response->assertStatus(401);

    }

  //*****************************DELETE********************************//

  /** @test */
  public function manager_can_delete_partner()
  {
    $this->loginAsManager('api');
    $partner =  factory(Partner::class)->create();

    $response =  $this->json('DELETE','/api/v1/partners/'.$partner->id);
    $result = json_decode($response->getContent());

    $response->assertSuccessful();
    $this->assertEquals($result->name, $partner->name);
    $this->assertNull(Partner::find($partner->id));

  }

  /** @test */
  public function superadmin_can_delete_partner()
  {
    $this->loginAsSuperAdmin('api');
    $partner =  factory(Partner::class)->create();

    $response =  $this->json('DELETE','/api/v1/partners/'.$partner->id);

    $result = json_decode($response->getContent());
    $response->assertSuccessful();
    $this->assertEquals($result->name,$partner->name);
    $this->assertNull(Partner::find($partner->id));
  }

  /** @test */
  public function regular_user_cannot_delete_partner()
  {
    $this->login('api');
    $partner =  factory(Partner::class)->create();

    $response =  $this->json('DELETE','/api/v1/partners/'.$partner->id);

    $result = json_decode($response->getContent());
    $response->assertStatus(403);
  }

  /** @test */
  public function guest_user_cannot_delete_partner()
  {
    $partner =  factory(Partner::class)->create();

    $response =  $this->json('DELETE','/api/v1/partners/'.$partner->id);

    $result = json_decode($response->getContent());
    $response->assertStatus(401);
  }

  //*****************************CREATE********************************//

  /** @test */
  public function cannot_create_partner_whiout_name()
  {
    $this->loginWithPermission('api','partners.store');
    $response = $this->json('POST','/api/v1/partners/',[
      'name' => ''
    ]);
    $response->assertStatus(422);
  }

  /** @test */
  public function superadmin_can_create_partner()
  {
    $this->loginAsSuperAdmin('api');
    $response = $this->json('POST','/api/v1/partners/',[
      'name' => 'Ajuntament',
      'category' => 'Bronze'
    ]);

    $result = json_decode($response->getContent());
    $response->assertSuccessful();

    $this->assertNotNull($partner = Partner::find($result->id));
    $this->assertEquals('Ajuntament',$result->name);
    $this->assertEquals('Bronze',$result->category);

    $this->assertEquals('Ajuntament',$partner->name);
    $this->assertEquals('Bronze',$partner->category);

  }

  /** @test */
  public function manager_can_create_partner()
  {
    $this->loginAsManager('api');

    $response = $this->json('POST','/api/v1/partners/',[
      'name' => 'Ajuntament',
      'category' => 'Bronze'
    ]);

    $result = json_decode($response->getContent());
    $response->assertSuccessful();

    $this->assertNotNull($partner = Partner::find($result->id));
    $this->assertEquals('Ajuntament',$result->name);
    $this->assertEquals('Bronze',$result->category);

    $this->assertEquals('Ajuntament',$partner->name);
    $this->assertEquals('Bronze',$partner->category);


  }

  /** @test */
  public function regular_user_cannot_create_partner()
  {
    $this->login('api');

    $response = $this->json('POST','/api/v1/partners/',[
      'name' => 'Ajuntament',
      'category' => 'Bronze'
    ]);

    json_decode($response->getContent());
    $response->assertStatus(403);

  }

  /** @test */
  public function guest_user_cannot_create_partner()
  {
    $response = $this->json('POST','/api/v1/partners/',[
      'name' => 'Ajuntament',
      'category' => 'Bronze'
    ]);

    json_decode($response->getContent());
    $response->assertStatus(401);

  }

  //*****************************INDEX********************************//
  /** @test */
  public function regular_user_cannot_index_partners()
  {
    $this->login('api');

    $response = $this->json('GET','/api/v1/partners');
    $response->assertStatus(403);
  }

}
