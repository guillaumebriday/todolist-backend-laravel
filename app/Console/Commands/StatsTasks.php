<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;

class StatsTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get stats for tasks.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['Description', 'Value'];

        $data = [
            [
                'Tasks count',
                Task::count()
            ],
            [
                'User count',
                User::count()
            ],
            [
                'Avarage tasks per user',
                User::withCount('tasks')->pluck('tasks_count')->average()
            ],
            [
                'New tasks last week',
                Task::where('created_at', '>=', now()->subWeek())->count()
            ],
            [
                'New tasks last month',
                Task::where('created_at', '>=', now()->subMonth())->count()
            ],
            [
                'New tasks last year',
                Task::where('created_at', '>=', now()->subYear())->count()
            ],
            [
                'Tasks with due_at date',
                Task::whereNotNull('due_at')->count()
            ],
            [
                'Tasks without due_at date',
                Task::whereNull('due_at')->count()
            ],
            [
                'Tasks completed',
                Task::completed()->count()
            ],
            [
                'Tasks not completed',
                Task::whereIsCompleted(false)->count()
            ]
        ];

        $this->table($headers, $data);
    }
}
