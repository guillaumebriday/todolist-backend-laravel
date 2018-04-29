<?php

use App\Models\Task;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'due_at' => null,
        'is_completed' => false,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(Task::class, 'completed', function (Faker $faker) {
    return [
        'is_completed' => true
    ];
});
