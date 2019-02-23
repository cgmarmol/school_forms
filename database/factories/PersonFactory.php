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

$factory->define(App\Models\Person::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstNameMale,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'gender' => 'M',
        'birth_date' => $faker->date('Y-m-d')
    ];
});
