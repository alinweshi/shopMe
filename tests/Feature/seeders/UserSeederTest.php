<?php

namespace Tests\Feature\seeders;

use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_seeder()
    {


        $this->seed(UsersTableSeeder::class);
        $this->assertDatabaseHas('users', [
            'first_name' => 'ali',
            'last_name' => 'mohamed',
            'email' => 'alinweshi@gmail.com'
        ]);
    }
    public function test_user_seeder_via_command()
    {
        $this->artisan('db:seed --class=UsersTableSeeder')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'first_name' => 'ali',
            'last_name' => 'mohamed',
            'email' => 'alinweshi@gmail.com'
        ]);
    }
}
