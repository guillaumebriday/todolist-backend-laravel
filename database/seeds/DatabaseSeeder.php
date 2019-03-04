<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::firstOrCreate(
            ['email' => 'darthvader@deathstar.ds'],
            [
                'name' => 'anakin',
                'password' => '4nak1n5kyw4lk3r'
            ]
        );
    }
}
