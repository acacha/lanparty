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

$factory->define(App\Prize::class, function (Faker $faker) {
    $faker = Factory::create('es_ES');
    return [
        'id' => 1,
        'name' => $faker->name,
        'description' => $faker->name,
        'session' => $faker->name,
        'notes' => $faker->name,
        'value' => 1,
        'partner_id'=>1,
    ];
});
