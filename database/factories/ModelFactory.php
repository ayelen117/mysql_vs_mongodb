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
use App\Models\Mysql\Responsibility;
use App\Models\Mysql\Currency;
use App\Models\Mysql\Receipt;
use App\Models\Mysql\Tax;
use Carbon\Carbon;
use App\Helpers\TestHelper;
use Illuminate\Support\Facades\DB;

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
/**
 * User factory
 */
$factory->defineAs(User::class, 'mongo', function (Faker\Generator $faker) {
    static $password;
    $array =  [
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

    return $array;
});

$factory->defineAs(User::class, 'mysql', function (Faker\Generator $faker) {
    static $password;

    $array =  [
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

    return $array;
});

/**
 * Company factory
 */
$factory->defineAs(Company::class, 'mysql', function (Faker\Generator $faker) {
//	$users = DB::select('select id from users');
//	$user_id = $users[array_rand($users, 1)]->id;
//
//	$responsibilities = DB::select('select id from responsibilities');
//	$responsibility_id = $responsibilities[array_rand($responsibilities, 1)]->id;
//
	$array =  [
        'name' => $faker->company,
        'status' => 'activated',
        'user_id' => $faker->randomElement(User::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
//        'currencies' => [],  // todo: agregar relacion
        'abbreviation' => $faker->numerify('t_###'),
        'description' => $faker->sentence(5),
        'cuit' => '2735663969',
        'legal_name' => $faker->company,
        'street_name' => $faker->streetName,
        'street_number' => $faker->numberBetween(150, 900),
        'phone' => $faker->phoneNumber,
        'fiscal_ws' => '',
        'fiscal_ws_status' => '',
        'responsibility_id' => $faker->randomElement(Responsibility::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
    ];

    return $array;
});

$factory->defineAs(Company::class, 'mongo', function (Faker\Generator $faker) {
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

/**
 * Category factory
 */
$factory->defineAs(Category::class, 'mysql', function (Faker\Generator $faker) {
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
	
    $array =  [
        'name' => $faker->numerify('category_###'),
        'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'parent_id' => null,
    ];

    return $array;
});

$factory->defineAs(Category::class, 'mongo', function (Faker\Generator $faker) {
    $array =  [
        'name' => $faker->numerify('category_###'),
        'company_id' => null,
        'parent_id' => null,
    ];
    $array = (new TestHelper())->addRandomObjectToArray($array, 'companies', 'company_id');

    return $array;
});

/**
 * Fiscalpos factory
 */
$factory->defineAs(Fiscalpos::class, 'mysql', function (Faker\Generator $faker) {
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
	
    $array =  [
        'number' => $faker->numerify('##'),
        'pos_type' => $faker->randomElement(['electronic', 'fiscal_printer', 'manual']),
        'alias' => $faker->word(),
        'status' => $faker->boolean(),
        'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(10)->get()->pluck('id')->toArray()),
        'default' => $faker->boolean(),
        'fiscaltoken' => ''
        ];

    return $array;
});

$factory->defineAs(Fiscalpos::class, 'mongo', function (Faker\Generator $faker) {
    $array =  [
        'number' => $faker->numerify('##'),
        'pos_type' => $faker->randomElement(['electronic', 'fiscal_printer', 'manual']),
        'alias' => $faker->word(),
        'status' => $faker->boolean(),
        'company_id' => null,
        'default' => $faker->boolean(),
        'fiscaltoken' => ''
    ];
    $array = (new TestHelper())->addRandomObjectToArray($array, 'companies', 'company_id');

    return $array;
});

/**
 * Product factory
 */
$factory->defineAs(Product::class, 'mysql', function (Faker\Generator $faker) {

//	$users = DB::select('select id from users');
//	$user_id = $users[array_rand($users, 1)]->id;
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
//	$categories = DB::select('select id from categories');
//	$category_id = $categories[array_rand($categories, 1)]->id;
//	$taxes = DB::select('select id from taxes');
//	$tax_id = $taxes[array_rand($taxes, 1)]->id;
//	$currencies = DB::select('select id from currencies');
//	$currency_id = $currencies[array_rand($currencies, 1)]->id;
	
	$array = [
		'name' => $faker->word,
		'description' => $faker->sentence(),
		'barcode' => $faker->isbn10,
		'product_type' => $faker->randomElement(['product', 'service']),
		'duration' => 1,
		'stock_type' => 'negative',
		'replacement_cost' => '1',
		'author_id' => $faker->randomElement(User::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
		'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
		'category_id' => $faker->randomElement(Category::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
		'tax_id' => $faker->randomElement(Tax::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
		'currency_id' => $faker->randomElement(Currency::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
		'stock' => $faker->numerify('##'),
		'stock_alert' => $faker->numerify('##'),
		'stock_desired' => $faker->numerify('##'),
		'high' => '0.00',
		'width' => '0.00',
		'length' => '0',
		'weight' => '0',
		'weight_element' => '0',
//        'pricelists' => [],
	];

    return $array;
});

$factory->defineAs(Product::class, 'mongo', function (Faker\Generator $faker) {
    $helper = new TestHelper();

    $array = [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'barcode' => $faker->isbn10,
        'product_type' => $faker->randomElement(['product', 'service']),
        'stock_type' => 'negative',
        'duration' => 1,
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

/**
 * Pricelist factory
 */
$factory->defineAs(Pricelist::class, 'mysql', function (Faker\Generator $faker) {
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
//
    $array =  [
        'name' => $faker->word,
        'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'percent_price' => $faker->randomFloat(2, 0, 50),
        'percent_subdist' => $faker->randomFloat(2, 0, 50),
        'percent_prevent' => $faker->randomFloat(2, 0, 50),
    ];

    return $array;
});

$factory->defineAs(Pricelist::class, 'mongo', function (Faker\Generator $faker) {
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

/**
 * PricelistProduct factory
 */
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

/**
 * Entity factory
 */
$factory->defineAs(Entity::class, 'mysql', function (Faker\Generator $faker) {
//	$users = DB::select('select id from users');
//	$user_id = $users[array_rand($users, 1)]->id;
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
//	$pricelists = DB::select('select id from pricelists');
//	$pricelist_id = $pricelists[array_rand($pricelists, 1)]->id;
	
    $array = [
        'name' => $faker->firstName,
        'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'author_id' => $faker->randomElement(User::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
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
        'pricelist_id' => $faker->randomElement(Pricelist::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
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

/**
 * Inventory factory
 */
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

/**
 * Document factory
 */
$factory->defineAs(Document::class, 'mysql', function (Faker\Generator $faker) {
//	$users = DB::select('select id from users');
//	$user_id = $users[array_rand($users, 1)]->id;
//	$companies = DB::select('select id from companies');
//	$company_id = $companies[array_rand($companies, 1)]->id;
//	$entities = DB::select('select id from entities');
//	$entity_id = $entities[array_rand($entities, 1)]->id;
//	$currencies = DB::select('select id from currencies');
//	$currency_id = $currencies[array_rand($currencies, 1)]->id;
//	$receipts = DB::select('select id from receipts');
//	$receipt_id = $receipts[array_rand($receipts, 1)]->id;
	
    $array = [
        'author_id' => $faker->randomElement(User::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'company_id' => $faker->randomElement(Company::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'entity_id' => $faker->randomElement(Entity::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'seller_id' => $faker->randomElement(Entity::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'currency_id' => $faker->randomElement(Currency::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
        'receipt_id' => $faker->randomElement(Receipt::where('id', '!=', 0)->limit(1000)->get()->pluck('id')->toArray()),
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
//        'details' => [],
        'parent_id' => null,
        'fiscal_observation' => '',
        'canceled' => false,
        'show_amounts' => true,
//        'children' => [],
//        'ancestors' => [],
//        'transactions' => [],
    ];

    return $array;
});

$factory->defineAs(Document::class, 'mongo', function (Faker\Generator $faker) {

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
        'parent_id' => null,
        'fiscal_observation' => '',
        'canceled' => false,
        'show_amounts' => true,
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

/**
 * Detail factory
 */
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

/**
 * Transaction factory
 */
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