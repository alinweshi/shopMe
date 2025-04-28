<?php

namespace Tests\Feature\Blades;

use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_welcome()
    {
        $this->get('/')
            ->assertSeeText('Laravel');
        $response = $this->get('/');
        // $response->dd();
        $response->ddHeaders();
        // $response->ddBody();
        // $response->ddJson();
        // $response->ddSession();
    }
}
