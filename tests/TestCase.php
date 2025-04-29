<?php

namespace Tests;

use Illuminate\Support\Facades\Vite;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Proper Vite mock
        Vite::shouldReceive('__invoke')
            ->andReturn('http://localhost:3000/@vite/client');

        Vite::shouldReceive('asset')
            ->andReturn('http://localhost:3000/resources/css/app.css');
    }
}
