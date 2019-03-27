<?php

namespace Tests\Feature;

use Newsletter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NewsletterTest.
 *
 * @package Tests\Feature
 */
class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @group skip
     */
    public function guest_users_can_subscribe_to_newsletter()
    {
        Newsletter::shouldReceive('subscribePending')
            ->once()
            ->with('prova@gmail.com')
            ->andReturn('value'); // Return some value to avoid 422 errors

        $response = $this->json('POST','/api/v1/newsletter', [ 'email' => 'prova@gmail.com' ]);

        $response->assertSuccessful();
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->json('POST','/api/v1/newsletter', [ 'email' => null ]);
        $response->assertStatus(422);

        $response = $this->json('POST','/api/v1/newsletter', [ 'email' => 'invalidemail' ]);
        $response->assertStatus(422);
    }
}
