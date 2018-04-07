<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        if (User::where('email', 'darthvader@deathstar.ds')->doesntExist()) {
            User::create([
                'name' => 'anakin',
                'email' => 'darthvader@deathstar.ds',
                'password' => '4nak1n'
            ]);
        }
    }
}
