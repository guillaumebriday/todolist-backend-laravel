<?php

use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'due_at' => null,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(Task::class, 'schedule', function (Faker $faker) {
    return [
        'due_at' => now()
    ];
});
