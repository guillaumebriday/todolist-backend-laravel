<?php

namespace App\Http\Controllers\V1;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TasksDeleted;
use App\Events\TaskUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection(
            Task::all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = auth()->user()->tasks()->create($request->validated());

        broadcast(new TaskCreated($task))->toOthers();

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTaskRequest  $request
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        broadcast(new TaskUpdated($task))->toOthers();

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {
        broadcast(new TaskDeleted($task))->toOthers();

        $task->delete();

        return response()->noContent();
    }

    /**
     * Remove the all completed tasks from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCompletedTasks(Request $request)
    {
        broadcast(new TasksDeleted)->toOthers();

        Task::completed()->delete();

        return response()->noContent();
    }
}
