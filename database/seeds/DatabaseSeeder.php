<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users
        User::firstOrCreate(
            ['email' => 'darthvader@deathstar.ds'],
            [
                'name' => 'anakin',
                'password' => '4nak1n'
            ]
        );
    }
}
