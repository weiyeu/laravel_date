<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {

    // gender random array
    $genderArr = ['male', 'female'];

    return [
        'nickname' => $faker->userName,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'real_name' => $faker->firstName,
        'sex' => $genderArr[array_rand($genderArr, 1)],
        'year' => $faker->year,
        'month' => $faker->month,
        'date' => $faker->dayOfMonth,
        'phone_number' => $faker->phoneNumber,
        'confirmed' => 1,
        'remember_token' => str_random(10),
    ];
});
