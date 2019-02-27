<?php

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

$factory->define(App\Models\Section::class, function (Faker $faker) {
    return [
        'academic_year' => '2019-2020',
        'semester' => rand(1, 2),
        'name' => $faker->text()
    ];
});
