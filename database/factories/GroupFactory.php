<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'avatar' => $faker->word,
        'leader' => factory(User::class)->create()->id
    ];
});
