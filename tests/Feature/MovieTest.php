<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_movie_list_all(): void
    {
        $response = $this->getJson('/api/v1/movie/list?page_size=1', [
            'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
            'Accept' => 'application/json',
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_movie_create(): void
    {
        $response = $this->postJson(
            '/api/v1/movie/store',
            [
                'title' => 'Teste de filme',
                'description' => 'Teste create',
                'release_date' => '2023-12-14',
                'genre_ids' => ['2', '3']
            ],
            [
                'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
                'Accept' => 'application/json',
                'Accept' => 'application/json'
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_movie_find(): void
    {
        $response = $this->getJson('/api/v1/movie/1/find', [
            'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
            'Accept' => 'application/json',
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_movie_update(): void
    {
        $response = $this->putJson(
            '/api/v1/movie/6/update',
            [
                'title' => 'Velozes & Furiosos 99',
                'description' => 'Teste updated',
                'release_date' => '2023-12-14',
                'genre_ids' => ['4']
            ],
            [
                'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
                'Accept' => 'application/json',
                'Accept' => 'application/json'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_movie_delete(): void
    {
        $response = $this->deleteJson(
            '/api/v1/movie/6/delete',
            [],
            [
                'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
                'Accept' => 'application/json',
                'Accept' => 'application/json'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_movie_streaming_sync(): void
    {
        $response = $this->postJson(
            '/api/v1/streaming/movie/vincule',
            [
                'streaming_id' => '2',
                'movie_ids' => ['5']
            ],
            [
                'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
                'Accept' => 'application/json',
                'Accept' => 'application/json'
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }
}
