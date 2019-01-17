<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'company_id' => function () {
            $company = App\Company::inRandomOrder()->first();
            return $company->id;
        }
    ];
});
