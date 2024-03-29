<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class MovieTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // use DatabaseTransactions;

    public function test_movie_list_all(): void
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $response = $this->getJson('/api/v1/movie/list?page_size=1', [
            'Authorization' => 'Bearer 1|0N4yeuzy6aLlydWXUHvJWzxBVqWf0sqJbJoXZLbJ51566a59',
            'Accept' => 'application/json',
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_title_should_be_required()
    {
        $response = $this->postJson(
            route('register.movie'),
            []
        );
        // dd(session()->all());
        $response->assertInvalid(['title' => 'Movie title is required.']);
    }

    public function test_description_should_have_a_max_off_255_characters()
    {
        $this->post(
            route('register.movie'),
            [
                'description' => str_repeat('a', 256),
            ]
        )
            // ->assertSessionHasErrors(['description' => __('validation.max.string', ['atribute' => 'description', 'max' => 255])])
            ->assertInvalid([
                'description' => 'The description field must not be greater than 255 characters.'
            ]);
    }

    public function test_movie_create(): void
    {
        $response = $this->postJson(
            // route('api.movie.store'),
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
