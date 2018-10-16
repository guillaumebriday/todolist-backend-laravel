<?php

namespace Tests\Feature\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_retrieve_a_jwt()
    {
        $this->anakin();

        $this->json('POST', '/api/v1/auth/login', [
                'email' => 'anakin@skywalker.st',
                'password' => '4nak1n'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user_id',
            ])
            ->assertJson([
                'token_type' => 'bearer',
                'expires_in' => 3600
            ]);
    }

    /** @test */
    public function user_cannot_retrieve_a_jwt()
    {
        $this->json('POST', '/api/v1/auth/login', [
                'email' => 'anakin@skywalker.st',
                'password' => 'Luk3'
            ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ]);
    }

    /** @test */
    public function user_can_be_authenticated_with_jwt()
    {
        $anakin = $this->anakin();
        $anakin->wasRecentlyCreated = false;

        $this->actingAs($anakin)
            ->json('GET', '/api/v1/auth/me')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                ]
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Anakin',
                    'email' => 'anakin@skywalker.st'
                ]
            ]);
    }

    /** @test */
    public function user_must_be_authenticated()
    {
        $this->json('GET', '/api/v1/auth/me')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }
}
