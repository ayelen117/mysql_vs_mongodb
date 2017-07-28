<?php

use App\Models\Mysql\User;
use App\Models\Mysql\Company;
use App\Models\Mysql\Category;
use App\Models\Mysql\Fiscalpos;
use App\Models\Mysql\Product;
use App\Models\Mysql\Pricelist;
use App\Models\Mysql\PricelistProduct;
use App\Helpers\TestHelper;
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
    $helper = new TestHelper();

    $array =  [
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
    $array = $helper->addRandomObjectToArray($array, 'users', 'user_id');
    $array = $helper->addRandomObjectToArray($array, 'currencies', 'currencies', 2);
    $array = $helper->addRandomObjectToArray($array, 'responsibilities', 'responsibility_id');

    return $array;
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    $array =  [
        'name' => $faker->numerify('category_###'),
        'company_id' => null,
        'parent_id' => null,
    ];
    $array = (new TestHelper())->addRandomObjectToArray($array, 'companies', 'company_id');

    return $array;
});

$factory->define(Fiscalpos::class, function (Faker\Generator $faker) {
    $array =  [
        'number' => $faker->numerify('##'),
        'pos_type' => $faker->randomElement(['electronic', 'fiscal_printer', 'manual']),
        'alias' => $faker->word(),
        'status' => $faker->boolean(),
        'company_id' => null,
    ];
    $array = (new TestHelper())->addRandomObjectToArray($array, 'companies', 'company_id');

    return $array;
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    $helper = new TestHelper();

    $array = [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'barcode' => $faker->isbn10,
        'product_type' => $faker->randomElement(['product', 'service']),
        'stock_type' => 'negative',
        'replacement_cost' => '1',
        'author_id' => null,
        'company_id' => null,
        'category_id' => null,
        'tax_id' => null,
        'currency_id' => null,
        'stock' => $faker->numerify('##'),
        'stock_alert' => $faker->numerify('##'),
        'stock_desired' => $faker->numerify('##'),
        'high' => '0.00',
        'width' => '0.00',
        'length' => '0',
        'weight' => '0',
        'weight_element' => '0',
        'pricelists' => [],
    ];

    $array['pricelists'] = factory(PricelistProduct::class, 2)->make()->toArray();
    $array = $helper->addRandomObjectToArray($array, 'companies', 'company_id');
    $array = $helper->addRandomObjectToArray($array, 'users', 'author_id');
    $array = $helper->addRandomObjectToArray($array, 'categories', 'category_id');
    $array = $helper->addRandomObjectToArray($array, 'taxes', 'tax_id');
    $array = $helper->addRandomObjectToArray($array, 'currencies', 'currency_id');

    return $array;
});

$factory->define(Pricelist::class, function (Faker\Generator $faker) {
    $array =  [
        'name' => $faker->word,
        'company_id' => null,
        'percent_price' => $faker->randomFloat(2, 0, 50),
        'percent_subdist' => $faker->randomFloat(2, 0, 50),
        'percent_prevent' => $faker->randomFloat(2, 0, 50),
    ];
    $array = (new TestHelper())->addRandomObjectToArray($array, 'companies', 'company_id');

    return $array;
});

$factory->define(PricelistProduct::class, function (Faker\Generator $faker) {

    $array = [
        'pricelist_id' => null,
        'price' => $faker->randomFloat(2, 0, 100),
        'percent_subdist' => $faker->randomFloat(2, 0, 50),
        'percent_prevent' => $faker->randomFloat(2, 0, 50),
        'activated' => $faker->boolean(),
    ];
    $array =(new TestHelper())->addRandomObjectToArray($array, 'pricelists', 'pricelist_id');

    return $array;
});