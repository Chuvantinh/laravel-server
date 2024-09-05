<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;


class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    use RefreshDatabase;
    
    public function test_user_can_access_protected_route_with_sanctum_token()
    {
        // Create a test user
        $user = User::factory()->create();

        // Simulate the user being authenticated via Sanctum
        Sanctum::actingAs($user, ['*']); // '*' means all abilities

        // Hit the protected route
        $response = $this->getJson('/api/user');

        // Assert that the response is OK
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_protected_route()
    {
        // Hit the protected route without authentication
        $response = $this->getJson('/api/user');

        // Assert that the response is 401 Unauthorized
        $response->assertStatus(401);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }
}
