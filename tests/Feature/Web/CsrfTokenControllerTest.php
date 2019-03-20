<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Console\Kernel;

/**
 * Class CsrfTokenControllerTest.
 *
 * @package Tests\Feature\Tenants\Api\CsrfToken
 */
class CsrfTokenControllerTest extends TestCase{

    use RefreshDatabase;

    /** @test */
    public function can_get_csrf_token()
    {
        $this->withoutExceptionHandling();
        $result = $this->get('/csrftoken');
        $result->assertSuccessful();
        $this->assertEquals(csrf_token(),$result->getContent());
    }

}
