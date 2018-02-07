<?php

use Faker\Generator as Faker;

$factory->define(App\Number::class, function (Faker $faker) {
    return [
        'value' => $faker->unique->numberBetween(1,500)
    ];
});
