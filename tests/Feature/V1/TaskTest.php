<?php

namespace Tests\Feature\V1;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_retrieve_all_tasks()
    {
        $anakin = $this->anakin();
        factory(Task::class, 3)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('GET', '/api/v1/tasks')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'title',
                    'due_at',
                    'is_completed',
                    'author' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]],
            ])
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function user_cannot_retrieve_another_tasks()
    {
        $anakin = $this->anakin();
        factory(Task::class, 3)->create(['user_id' => $anakin]);
        factory(Task::class, 3)->create();

        $this->assertEquals(Task::count(), 6);

        $this->actingAs($anakin)
            ->json('GET', '/api/v1/tasks')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function user_can_retrieve_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('GET', "/api/v1/tasks/{$task->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'due_at',
                    'author' => [
                        'id',
                        'name',
                        'email'
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'due_at' => null,
                    'is_completed' => false,
                    'author' => [
                        'id' => $anakin->id,
                        'name' => $anakin->name,
                        'email' => $anakin->email
                    ]
                ]
            ])
            ->assertJsonCount(1);
    }

    /** @test */
    public function user_cannot_retrieve_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($this->user())
            ->json('GET', "/api/v1/tasks/{$task->id}")
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    /** @test */
    public function user_can_update_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/tasks/{$task->id}", [
                'title' => 'Get groceries',
                'due_at' => now()->toDateTimeString(),
                'is_completed' => true,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'due_at',
                    'author' => [
                        'id',
                        'name',
                        'email'
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $task->id,
                    'title' => 'Get groceries',
                    'due_at' => now()->toATOMString(),
                    'is_completed' => true,
                    'author' => [
                        'id' => $anakin->id,
                        'name' => $anakin->name,
                        'email' => $anakin->email
                    ]
                ]
            ])
            ->assertJsonCount(1);
    }

    /** @test */
    public function user_cannot_update_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($this->user())
            ->json('PATCH', "/api/v1/tasks/{$task->id}", [
                'title' => 'Get groceries'
            ])
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    /** @test */
    public function user_can_complete_a_task_without_updating_title()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/tasks/{$task->id}", [
                'is_completed' => true,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'due_at',
                    'author' => [
                        'id',
                        'name',
                        'email'
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'due_at' => $task->due_at,
                    'is_completed' => true,
                    'author' => [
                        'id' => $anakin->id,
                        'name' => $anakin->name,
                        'email' => $anakin->email
                    ]
                ]
            ])
            ->assertJsonCount(1);

        $this->assertEquals($task->title, $task->refresh()->title);
        $this->assertTrue($task->is_completed);
    }

    /** @test */
    public function user_can_create_a_task_with_timezone()
    {
        $anakin = $this->anakin();

        $this->actingAs($anakin)
            ->json('POST', "/api/v1/tasks", [
                'title' => 'Get groceries',
                'due_at' => '2018-08-25T12:00:00+02:00'
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'due_at',
                    'author' => [
                        'id',
                        'name',
                        'email'
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'title' => 'Get groceries',
                    'due_at' => '2018-08-25T10:00:00+00:00',
                    'is_completed' => false,
                    'author' => [
                        'id' => $anakin->id,
                        'name' => $anakin->name,
                        'email' => $anakin->email
                    ]
                ]
            ])
            ->assertJsonCount(1);
    }

    /** @test */
    public function user_can_create_a_task_without_timezone()
    {
        $anakin = $this->anakin();

        $this->actingAs($anakin)
            ->json('POST', "/api/v1/tasks", [
                'title' => 'Get groceries',
                'due_at' => '2018-08-25 12:00:00'
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'due_at' => '2018-08-25T12:00:00+00:00'
                ]
            ]);
    }

    /** @test */
    public function user_can_remove_the_due_at_date()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create([
            'user_id' => $anakin,
            'due_at' => now()
        ]);

        $this->actingAs($anakin)
            ->json('PATCH', "/api/v1/tasks/{$task->id}", [
                'due_at' => null,
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'due_at' => null
                ]
            ]);
    }

    /** @test */
    public function user_can_delete_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('DELETE', "/api/v1/tasks/{$task->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    /** @test */
    public function user_cannot_delete_a_task()
    {
        $anakin = $this->anakin();
        $task = factory(Task::class)->create(['user_id' => $anakin]);

        $this->actingAs($this->user())
            ->json('DELETE', "/api/v1/tasks/{$task->id}")
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);

        $this->assertDatabaseHas('tasks', $task->toArray());
    }

    /** @test */
    public function user_can_delete_all_completed_tasks()
    {
        $anakin = $this->anakin();
        factory(Task::class, 2)->create(['user_id' => $anakin]);
        factory(Task::class, 2)->states('completed')->create(['user_id' => $anakin]);

        $this->actingAs($anakin)
            ->json('DELETE', '/api/v1/tasks')
            ->assertStatus(204);

        $this->assertEmpty(Task::completed()->get());
        $this->assertCount(2, Task::all());
    }
}
