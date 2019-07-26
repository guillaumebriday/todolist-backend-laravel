<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_if_task_is_completed()
    {
        $anakin = $this->anakin();
        $this->actingAs($anakin);

        $NotCompletedTask = factory(Task::class)->create(['user_id' => $anakin->id]);
        $completedTask = factory(Task::class)->states('completed')->create(['user_id' => $anakin->id]);

        $this->assertTrue($completedTask->is_completed);
        $this->assertFalse($NotCompletedTask->is_completed);
    }

    /** @test */
    public function only_completed_tasks_are_returned()
    {
        $anakin = $this->anakin();
        $this->actingAs($anakin);

        factory(Task::class, 2)->create(['user_id' => $anakin->id]);
        factory(Task::class, 2)->states('completed')->create(['user_id' => $anakin->id]);

        $onlyCompleted = true;
        foreach (Task::completed()->get() as $task) {
            $onlyCompleted = $task->is_completed;

            if (! $onlyCompleted) {
                break;
            }
        }

        $this->assertTrue($onlyCompleted);
        $this->assertCount(4, Task::all());
        $this->assertCount(2, Task::completed()->get());
    }
}
