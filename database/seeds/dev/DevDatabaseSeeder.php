<?php

use App\Models\Task;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tasks
        factory(Task::class, 10)->create();
    }
}
