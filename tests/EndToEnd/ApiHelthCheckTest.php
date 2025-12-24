<?php

namespace Tests\EndToEnd;

use Tests\TestCase;

class ApiHelthCheckTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}
