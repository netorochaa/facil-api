<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JWTAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_user()
    {
        $response = $this->postJson(
            route('register'),
            [
                'name' => 'User Test',
                'email' => 'user@test.com',
                'password' => 'password',
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['user', 'token']);

        $user = User::where('email', 'user@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('User Test', $user->name);
    }

    public function test_it_login_a_user()
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson(
            route('login'),
            [
                'email' => 'user@test.com',
                'password' => 'password',
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_it_returns_error_if_credentials_are_invalid()
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson(
            route('login'),
            [
                'email' => 'user@test.com',
                'password' => 'incorrect-password',
            ]
        );

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }

    public function it_returns_error_if_user_is_not_found()
    {
        $response = $this->postJson(route('login'), [
            'email' => 'non-existent@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }
}
