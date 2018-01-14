<?php

namespace Tests\Unit;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tasks_are_scope_to_the_current_user()
    {
        $anakin = $this->anakin();
        $this->actingAs($anakin);

        factory(Task::class)->create(['user_id' => $anakin->id]);
        factory(Task::class)->create();

        $this->assertCount(1, Task::all());
        $this->assertCount(2, Task::withoutGlobalScopes()->get());
    }
}
