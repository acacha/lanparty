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

  /** @test */
  public function superadmin_can_index_partners()
  {
    $this->loginAsSuperAdmin('api');

    create_partners_2019();

    $response = $this->json('GET','/api/v1/partners');
    $response->assertSuccessful();

    $result = json_decode($response->getContent());

    $this->assertCount(17,$result);

    $this->assertEquals('Ajuntament de Tortosa',$result[0]->name);
    $this->assertEquals('2019',$result[0]->session);
    $this->assertEquals(null,$result[0]->category);
    $this->assertEquals('/img/logos/Ajuntament.jpg',$result[0]->avatar);

    $this->assertEquals('Dep. Informatica Institut de l\'Ebre',$result[1]->name);
    $this->assertEquals('2019',$result[1]->session);
    $this->assertEquals(null,$result[1]->category);
    $this->assertEquals('/img/logos/iesEbre.jpg',$result[1]->avatar);

  }

  /** @test */
  public function manager_can_index_partners()
  {
    $this->loginAsManager('api');

    create_partners_2019();

    $response = $this->json('GET','/api/v1/partners');
    $response->assertSuccessful();

    $result = json_decode($response->getContent());

    $this->assertCount(17,$result);

    $this->assertEquals('Ajuntament de Tortosa',$result[0]->name);
    $this->assertEquals('2019',$result[0]->session);
    $this->assertEquals(null,$result[0]->category);
    $this->assertEquals('/img/logos/Ajuntament.jpg',$result[0]->avatar);

    $this->assertEquals('Dep. Informatica Institut de l\'Ebre',$result[1]->name);
    $this->assertEquals('2019',$result[1]->session);
    $this->assertEquals(null,$result[1]->category);
    $this->assertEquals('/img/logos/iesEbre.jpg',$result[1]->avatar);



  }

  //*****************************EDIT********************************/

  /** @test */
  public function regular_user_cannot_edit_partner()
  {
    $this->login('api');

    $oldPartner =factory(Partner::class)->create([
            'name' => 'Bar Thomas'
    ]);

    $response = $this->json('PUT','/api/v1/partners/'.$oldPartner->id,[
      'name' => 'Bar Paco'
    ]);

    json_decode($response->getContent());
    $response->assertStatus(403);

  }

  /** @test */
  public function guest_user_cannot_edit_partner()
  {
    $oldPartner =factory(Partner::class)->create([
      'name' => 'Bar Thomas'
    ]);

    $response = $this->json('PUT','/api/v1/partners/'.$oldPartner->id,[
      'name' => 'Bar Paco'
    ]);

    json_decode($response->getContent());
    $response->assertStatus(401);
  }

  /** @test */
  public function superadmin_can_edit_partner()
  {
    $this->loginAsSuperAdmin('api');

    $oldPartner =factory(Partner::class)->create([
      'name' => 'Bar Thomas'
    ]);

    $response = $this->json('PUT','/api/v1/partners/'.$oldPartner->id,[
      'name' => 'Bar Paco'
    ]);

    $result =json_decode($response->getContent());
    $response->assertSuccessful();

    $newPartner =  $oldPartner->refresh();
    $this->assertNotNull($newPartner);
    $this->assertEquals('Bar Paco', $result->name);
  }

  /** @test */
  public function manager_can_edit_partner()
  {
    $this->loginAsManager('api');

    $oldPartner =factory(Partner::class)->create([
      'name' => 'Bar Thomas'
    ]);

    $response = $this->json('PUT','/api/v1/partners/'.$oldPartner->id,[
      'name' => 'Bar Paco'
    ]);

    $result =json_decode($response->getContent());
    $response->assertSuccessful();

    $newPartner =  $oldPartner->refresh();
    $this->assertNotNull($newPartner);
    $this->assertEquals('Bar Paco', $result->name);
  }

  /** @test */
  public function cannot_edit_partner_without_name()
  {
    $this->loginAsManager('api');

    $oldPartner = factory(Partner::class)->create();
    $response = $this->json('PUT','/api/v1/partners/'.$oldPartner->id,[
      'name' => ''
    ]);

    $response->assertStatus(422);
  }
}

