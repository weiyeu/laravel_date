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

$factory
    ->define(App\User::class, function (Faker\Generator $faker) {

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
$factory
    ->define(App\DateApplication::class, function (Faker\Generator $faker) {

        // city array
        $cityArr = ['台北', '新竹', '我都可以唷'];

        // vegetarian type array
        $vegetarianTypeArr = ['是', '否', '我都可以唷'];

        // meal type array
        $mealTypeArr = ['西餐', '中餐', '我都可以唷'];

        // gender array
        $genderArr = ['男', '女', '我都可以唷'];

        // time minutes array
        $minuteArr = ['30', '00'];

        // time range
        $timeArr = range(1700, 2300, 100);

        // time range
        $timeRange = array_rand($timeArr, 2);

        // start time
        $startTime = 0;

        // end time
        $endTime = 0;

        if ($timeArr[$timeRange[0]] > $timeArr[$timeRange[1]]) {
            $startTime = $timeArr[$timeRange[1]];
            $endTime = $timeArr[$timeRange[0]];
        } else {
            $startTime = $timeArr[$timeRange[0]];
            $endTime = $timeArr[$timeRange[1]];
        }


        return [
            'user_id' => factory(App\User::class)->create()->id,
            'city' => $cityArr[array_rand($cityArr, 1)],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'vegetarian_type' => $vegetarianTypeArr[array_rand($vegetarianTypeArr, 1)],
            'meal_type' => $mealTypeArr[array_rand($mealTypeArr, 1)],
            'sex_constraint' => $genderArr[array_rand($genderArr, 1)]
        ];
    });
