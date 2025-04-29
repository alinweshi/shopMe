<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Mock Vite for tests
        \Illuminate\Support\Facades\Vite::shouldReceive('asset')
            ->andReturn('http://localhost:3000/resources/css/app.css');
    }
}
