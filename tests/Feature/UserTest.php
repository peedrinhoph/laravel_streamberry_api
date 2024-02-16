<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_user_auth_endpoint(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => 'pedro23henrique@hotmail.com',
        ]);

        $response = $this->postJson(
            '/api/v1/login',
            [
                "email" => "pedro23henrique@hotmail.com",
                "password" => "123"
            ],
            [
                'Accept' => 'application/json',
                'Accept' => 'application/json'
            ]
        );

        $response->assertSuccessful();

        // $response
        //     ->assertStatus(200)
        //     ->assertJson([
        //         'success' => true,
        //     ]);

        $user = User::whereEmail('pedro23henrique@hotmail.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('123', $user->password),
            'Checking if pass was saved and it is encrypted'
        );
    }

    public function test_user_get_endpoint(): void
    {
        $response = $this->getJson('/api/v1/users', [
            'Authorization' => "Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59",
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
