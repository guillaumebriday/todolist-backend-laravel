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
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return TaskResource::collection(
            Task::all()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request): TaskResource
    {
        $task = auth()->user()->tasks()->create($request->validated());

        broadcast(new TaskCreated($task))->toOthers();

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task->update($request->validated());

        broadcast(new TaskUpdated($task))->toOthers();

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): JsonResponse
    {
        broadcast(new TaskDeleted($task))->toOthers();

        $task->delete();

        return response()->noContent();
    }

    /**
     * Remove the all completed tasks from storage.
     */
    public function deleteCompletedTasks(Request $request): JsonResponse
    {
        broadcast(new TasksDeleted)->toOthers();

        Task::completed()->delete();

        return response()->noContent();
    }
}
