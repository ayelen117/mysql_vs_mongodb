<?php

use App\Models\Mysql\User;
use App\Models\Mysql\Company;
use App\Models\Mysql\Category;
use App\Models\Mysql\Fiscalpos;
use App\Models\Mysql\Product;
use App\Models\Mysql\Pricelist;
use App\Models\Mysql\PricelistProduct;
use App\Models\Mysql\Entity;
use App\Models\Mysql\Inventory;
use App\Models\Mysql\Document;
use App\Models\Mysql\Detail;
use App\Models\Mysql\Transaction;
use Carbon\Carbon;
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
        'activated_at' => Carbon::yesterday()->toDateTimeString(),
        'last_login' => Carbon::now()->toDateTimeString(),
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
        'activities_start_date' => Carbon::today()->subYear()->toDateTimeString(),
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

$factory->defineAs(Entity::class, 'mysql', function (Faker\Generator $faker) {
    $array = [
        'name' => $faker->firstName,
        'company_id' => $faker->randomElement(Company::all()->pluck('id')->toArray()),
        'author_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'identification_id' => 25,
        'identification_number' => 20327936221,
        'contact_name' => $faker->firstName,
        'street_name' => $faker->streetName,
        'street_number' => $faker->numberBetween(150, 900),
        'latitude' => null,
        'longitude' => null, //-34.613265, -68.330706
        'additional_info' => $faker->sentence(3),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'pricelist_id' => $faker->randomElement(Pricelist::all()->pluck('id')->toArray()),
        'entity_type' => $faker->randomElement(['client', 'supplier', 'employee', 'creditor', 'subdist', 'seller']),
        'responsibility_id' => $faker->randomElement([1, 5, 6]),
        'observations' => $faker->sentence(),
        'has_account' => $faker->boolean(),
        'balance' => $faker->randomFloat(2, -1000, 10000),
        'balance_at' => Carbon::yesterday()->toDateTimeString(),
    ];

    return $array;
});

$factory->defineAs(Entity::class, 'mongo', function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'name' => $faker->name,
        'company_id' => null,
        'author_id' => null,
        'identification_id' => null,
        'identification_number' => $faker->numerify('########'),
        'contact_name' => $faker->firstName,
        'street_name' => $faker->streetName,
        'street_number' => $faker->numerify('###'),
        'latitude' => 0,
        'longitude' => 0,
        'additional_info' => $faker->sentence(),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'pricelist_id' => null,
        'entity_type' => $faker->randomElement(['client','supplier','employee','creditor','subdist','prevent','seller']),
        'responsibility_id' => null,
        'observations' => $faker->sentence(),
        'has_account' => $faker->boolean(),
        'balance' => $faker->randomFloat(2, -1000, 10000),
        'balance_at' => Carbon::yesterday()->toDateTimeString(),
        'parent'  => null,
        'children'  => [],
        'ancestors'  => [],
        'transactions' => []
    ];

    $array = $helper->addRandomObjectToArray($array, 'companies', 'company_id');
    $array = $helper->addRandomObjectToArray($array, 'users', 'author_id');
    $array = $helper->addRandomObjectToArray($array, 'identifications', 'identification_id');
    $array = $helper->addRandomObjectToArray($array, 'pricelists', 'pricelist_id');
    $array = $helper->addRandomObjectToArray($array, 'responsibilities', 'responsibility_id');
    $array = $helper->addRandomObjectToArray($array, 'transactions', 'transactions', 3);

    return $array;
});

$factory->define(Inventory::class, function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'qty' => 0,
        'current_stock_qty' => 0,
        'product_id' => null,
        'detail_id' => null,
        'unit_price' => $faker->randomFloat(2, 0, 10000),
        'total_price' => 0,
        'total' => 0,
    ];
    $array = $helper->addRandomObjectToArray($array, 'products', 'product_id');
    $array = $helper->addRandomObjectToArray($array, 'details', 'detail_id');

    return $array;
});

$factory->define(Document::class, function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'author_id' => null,
        'company_id' => null,
        'entity_id' => null,
        'seller_id' => null,
        'currency_id' => null,
        'receipt_id' => null,
        'section' => $faker->randomElement(['sales', 'purchases']),
        'receipt_type' => $faker->randomElement(['invoice', 'credit', 'debit', 'order_sell', 'order_buy', 'quotation', 'zeta']),
        'receipt_volume' => $faker->numerify('#'),
        'receipt_number' => $faker->numerify('00000###'),
        'total_commission' => $faker->randomFloat(2, 0, 10000),
        'total_cost' => $faker->randomFloat(2, 0, 10000),
        'total_net_price' => $faker->randomFloat(2, 0, 10000),
        'total_final_price' => $faker->randomFloat(2, 0, 10000),
        'emission_date' => Carbon::now()->toDateTimeString(),
        'cae' => $faker->numerify('###########'),
        'cae_expiration_date' => Carbon::now()->addMonth()->toDateTimeString(),
        'observation' => $faker->sentence(),
        'status' => $faker->randomElement(['draft', 'confirmed', 'failed']),
        'details' => [],
        'parent' => null,
        'children' => [],
        'ancestors' => [],
        'transactions' => [],
    ];

    $array['details'] = factory(Detail::class, 3)->make()->toArray();
    $array = $helper->addRandomObjectToArray($array, 'users', 'author_id');
    $array = $helper->addRandomObjectToArray($array, 'companies', 'company_id');
    $array = $helper->addRandomObjectToArray($array, 'entities', 'entity_id');
    $array = $helper->addRandomObjectToArray($array, 'entities', 'seller_id');
    $array = $helper->addRandomObjectToArray($array, 'currencies', 'currency_id');
    $array = $helper->addRandomObjectToArray($array, 'receipts', 'receipt_id');
    $array = $helper->addRandomObjectToArray($array, 'transactions', 'transactions',2);

    return $array;
});

$factory->define(Detail::class, function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'qty' => $faker->numerify('##'),
        'product_id' => null,
        'calculated_inventory_cost' => $faker->randomFloat(2, 10, 100),
        'subdist_price' => $faker->randomFloat(2, 10, 100),
        'net_unit_price' => $faker->randomFloat(2, 10, 100),
        'final_unit_price' => $faker->randomFloat(2, 10, 100),
        'commission' => $faker->randomFloat(2, 10, 100),
    ];
    $array = $helper->addRandomObjectToArray($array, 'products', 'product_id');

    return $array;
});

$factory->define(Detail::class, function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'qty' => $faker->numerify('##'),
        'product_id' => null,
        'calculated_inventory_cost' => $faker->randomFloat(2, 10, 100),
        'subdist_price' => $faker->randomFloat(2, 10, 100),
        'net_unit_price' => $faker->randomFloat(2, 10, 100),
        'final_unit_price' => $faker->randomFloat(2, 10, 100),
        'commission' => $faker->randomFloat(2, 10, 100),
    ];
    $array = $helper->addRandomObjectToArray($array, 'products', 'product_id');

    return $array;
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {

    $helper = new TestHelper();
    $array = [
        'due_date' => Carbon::today()->toDateString(),
        'amount' => $faker->randomFloat(2, 10, 100),
        'currency_id' => null,
        'observations' => $faker->sentence(),
    ];
    $array = $helper->addRandomObjectToArray($array, 'currencies', 'currency_id');

    return $array;
});