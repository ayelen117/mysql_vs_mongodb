<?php

use App\Models\Mysql\User;
use App\Models\Mysql\Company;
use App\Models\Mysql\Category;
use App\Models\Mysql\Fiscalpos;
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

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'activated' => 1,
        'banned' => 0,
        'super_admin' => 0,
        'activation_code' => null,
        'activated_at' => null,
        'last_login' => null,
    ];
});

$factory->define(Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'status' => 'activated',
        'user_id' => null,
        'currencies' => [],
        'abbreviation' => $faker->numerify('t_###'),
        'description' => $faker->sentence(5),
        'cuit' => '2735663969',
        'legal_name' => $faker->company,
        'gross_income' => $faker->numerify('####'),
        'activities_start_date' => '',
        'street_name' => $faker->streetName,
        'street_number' => $faker->numberBetween(150, 900),
        'phone' => $faker->phoneNumber,
        'fiscal_ws' => '',
        'fiscal_ws_status' => 0,
        'responsibility_id' => null,
    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->numerify('category_###'),
        'company_id' => null,
        'parent_id' => null,
    ];
});

$factory->define(Fiscalpos::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->numerify('##'),
        'pos_type' => $faker->randomElement(['electronic', 'fiscal_printer', 'manual']),
        'alias' => $faker->word(),
        'status' => $faker->boolean(),
        'company_id' => null,
    ];
});