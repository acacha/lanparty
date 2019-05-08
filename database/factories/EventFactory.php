<?php

use Faker\Factory;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Event::class, function (Faker $faker) {
    $faker = Factory::create('es_ES');

    return [
        'name' => $faker->name,
        'inscription_type_id' => $faker->unique()->randomNumber($nbDigits = 8),
        'image' => $faker->firstName,
        'regulation' => $faker->text,
        'session'=>$faker->text
    ];
});
