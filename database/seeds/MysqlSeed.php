<?php

use Illuminate\Database\Seeder;
use App\Models\Mysql\Identification;
use App\Models\Mysql\Receipt;
use App\Models\Mysql\Currency;
use App\Models\Mysql\Responsibility;
use App\Models\Mysql\User;
use App\Models\Mysql\Company;
use App\Models\Mysql\Pricelist;
use App\Models\Mysql\Entity;
use App\Models\Mysql\Category;
use App\Models\Mysql\Product;
use App\Models\Mysql\Document;
use App\Models\Mysql\Detail;
use App\Models\Mysql\FiscalPos;
use App\Models\Mysql\Inventory;
use App\Models\Mysql\PricelistProduct;
use App\Models\Mysql\Transaction;
use App\Models\Mysql\Measure;
use App\Models\Mysql\Tax;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class MysqlSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //Manual
        DB::table('currencies')->truncate();
        DB::table('identifications')->truncate();
        DB::table('measures')->truncate();
        DB::table('receipts')->truncate();
        DB::table('companies')->truncate();
        DB::table('responsibilities')->truncate();
        DB::table('taxes')->truncate();
        DB::table('pricelists')->truncate();
//        DB::table('categories')->truncate();
//        DB::table('company_currency')->truncate();
//        DB::table('details')->truncate();
//        DB::table('document_document')->truncate();
//        DB::table('document_transaction')->truncate();
//        DB::table('documents')->truncate();
//        DB::table('entities')->truncate();
//        DB::table('entity_entity')->truncate();
//        DB::table('fiscalpos')->truncate();
//        DB::table('inventories')->truncate();
//        DB::table('password_resets')->truncate();
//        DB::table('pricelist_product')->truncate();
//        DB::table('product_supplier')->truncate();
//        DB::table('products')->truncate();
//        DB::table('transactions')->truncate();
//
        /* IDENTIFICATIONS */
        if (Identification::all()->isEmpty()) {
            Identification::truncate();
            $identifications = config('migration.identifications');
            foreach ($identifications as $var) {
                Identification::create($var);
            }
        }
        echo "----IDENTIFICATIONS OK\n";

        /* RECEIPTS */
        if (Receipt::all()->isEmpty()) {
            Receipt::truncate();
            $receipts = config('migration.receipts');
            foreach ($receipts as $var) {
                Receipt::create($var);
            }
        }
        echo "----RECEIPTS OK\n";

        /* TAXES */
        if (Tax::all()->isEmpty()) {
            Tax::truncate();
            $taxes = config('migration.taxes');
            foreach ($taxes as $var) {
                Tax::create($var);
            }
        }
        echo "----TAXES OK\n";

        /* CURRENCIES */
        if (Currency::all()->isEmpty()) {
            Currency::truncate();
            $currencies = config('migration.currencies');
            foreach ($currencies as $var) {
                Currency::create($var);
            }
        }
        echo "----CURRENCIES OK\n";

        /* MEASURES */
        if (Measure::all()->isEmpty()) {
            Measure::truncate();
            $measures = config('migration.measures');
            foreach ($measures as $var) {
                Measure::create($var);
            }
        }
        echo "----MEASURES OK\n";

        /* RESPONSIBILITIES */
        if (Responsibility::all()->isEmpty()) {
            Responsibility::truncate();
            $responsibilities = config('migration.responsibilities');
            foreach ($responsibilities as $var) {
                Responsibility::create($var);
            }
        }
        echo "----RESPONSIBILITIES OK\n";

        /* USERS */
        User::truncate();
        $users           = config('migration.users');
        $userCollections = new Collection();
        foreach ($users as $var) {
            $var['password'] = bcrypt('multinexo');
            $user            = User::create($var);
            $userCollections->add($user);
        }
        echo "----USERS OK\n";

        /* COMPANIES */
        Company::truncate();
        $companiesCollection = new Collection();
        $responsibility_id   = Responsibility::where('code_afip', 1)->first()->id;
        $companies           = config('migration.companies');
        foreach ($companies as $var) {


            if ($var['abbreviation'] == 'me') {
                $user                     = $userCollections->where('email', 'demo@multinexo.com')->first();
                $var['user_id']           = $user->id;
                $var['responsibility_id'] = $responsibility_id;
            } else {
                $user                     = $userCollections->where('email', 'seed@multinexo.com')->first();
                $var['user_id']           = $user->id;
                $var['responsibility_id'] = $responsibility_id;
            }

            $company = Company::create($var);
            $companiesCollection->add($company);

        }

        echo "----COMPANIES OK\n";

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        $this->generatePricelistProducts();
//
//        /* DOCUMENT */
//        $objects = factory(Document::class,'test', 50)->make();
//        foreach ($objects as $var) {
//            $var->company_id = $entity->company_id;
//            $var->entity_id  = $entity->id;
//            Document::create($var->toArray());
//        }
//
//        /* TRANSACTION */
//        $objects = factory(Transaction::class,'test', 50)->make();
//        foreach ($objects as $var) {
//            $var->company_id = $entity->company_id;
//            $var->entity_id  = $entity->id;
//            Transaction::create($var->toArray());
//        }
//
//        factory(Check::class,50)->create();
//        factory(Transfer::class, 50)->create();
//
        /* PRICELISTS */

        $pricelists = config('migration.pricelists');
        foreach($pricelists as $var){
            $var['company_id']=$company->id;
            $pricelist = Pricelist::create($var);
        }
        echo "----PRICELISTS OK\n";

//        /* ENTITIES */
//        Entity::truncate();
//        $identification_id = Identification::where('name','CUIT')->first()->id;
//
//        //clients
//        $clients = config('migration.clients');
//        foreach($clients as $var){
//
//            $var['company_id']=$company->id;
//            $var['author_id']= $user->id;
//            $var['identification_id']=$identification_id;
//            $var['pricelist_id']=$pricelist->id;
//            $client = Entity::create($var);
//        }
//        //suppliers
//        $suppliers = config('migration.suppliers');
//        foreach($suppliers as $var){
//
//            $var['company_id']=$company->id;
//            $var['author_id']= $user->id;
//            $var['identification_id']=$identification_id;
//            $var['pricelist_id']=$pricelist->id;
//            $supplier = Entity::create($var);
//        }
//        echo "----ENTITIES OK\n";
//
//        /* CATEGORIES */
//        Category::truncate();
//        $categories = config('migration.categories');
//        foreach($categories as $var){
//
//            $var['company_id']=$company->id;
//            $category = Category::create($var);
//        }
//        echo "----CATEGORIES OK\n";
//
//        /* PRODUCTS */
//        Product::truncate();
//        $products = config('migration.products');
//        $currency_id = Currency::where('code_afip','PES')->first()->id;
//        $tax_id = Tax::where('code_afip',5)->first()->id;
//        foreach($products as $var){
//
//            $var['author_id']   =$user->id;
//            $var['company_id']  =$company->id;
//            $var['category_id'] =$category->id;
//            $var['currency_id'] =$currency_id;
//            $var['tax_id']      = $tax_id;
//            $product            = Product::create($var);
//            $product->saveProductName();
//
//        }
//        echo "----PRODUCTS OK\n";
    }
}
