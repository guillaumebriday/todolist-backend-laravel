<?php

namespace Tests\Feature\V1;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_his_account()
    {
        $anakin = $this->anakin();
        $tasks = factory(Task::class, 3)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('DELETE', "/api/v1/users/{$anakin->id}")
            ->assertStatus(204);

        $this->assertEmpty(Task::all());
        $this->assertDatabaseMissing('users', $anakin->toArray());
    }

    /** @test */
    public function user_can_update_his_account()
    {
        $anakin = $this->anakin();

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/users/{$anakin->id}", [
                'email' => 'ben@kenobi.jo',
                'name' => 'Ben',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $anakin->id,
                    'name' => 'Ben',
                    'email' => 'ben@kenobi.jo',
                ]
            ])
            ->assertJsonCount(1);

        $anakin->refresh();

        $this->assertEquals('ben@kenobi.jo', $anakin->email);
        $this->assertEquals('Ben', $anakin->name);
    }

    /** @test */
    public function user_cannot_update_another_account()
    {
        $user = $this->user();

        $this->actingAs($this->anakin())
            ->json('PATCH', "/api/v1/users/{$user->id}", [
                'email' => 'ben@kenobi.jo',
                'name' => 'Ben',
            ])
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    /** @test */
    public function user_can_update_his_password()
    {
        $anakin = $this->anakin();

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/users/{$anakin->id}", [
                'current_password' => '4nak1n',
                'password' => '4_n3w_h0p3',
                'password_confirmation' => '4_n3w_h0p3'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $anakin->id,
                    'name' => $anakin->name,
                    'email' => $anakin->email,
                ]
            ])
            ->assertJsonCount(1);

        $this->assertTrue(Hash::check('4_n3w_h0p3', $anakin->refresh()->password));
    }

    /** @test */
    public function user_cannot_update_his_password_without_current_password_and_password_confirmation()
    {
        $anakin = $this->anakin();

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/users/{$anakin->id}", [
                'password' => '4_n3w_h0p3',
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'current_password',
                    'password',
                ],
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'current_password' => [
                        'The current password field is required when password is present.'
                    ],
                    'password' => [
                        'The password confirmation does not match.'
                    ],
                ]
            ]);

        $this->assertFalse(Hash::check('4_n3w_h0p3', $anakin->refresh()->password));
    }
}
