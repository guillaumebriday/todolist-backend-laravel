<?php

use App\Models\Task;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tasks
        factory(Task::class, 10)->create();
    }
}
