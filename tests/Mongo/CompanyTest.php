<?php

namespace tests\Mongo\CompanyTests;

use App\Helpers\TestHelper;
use App\Models\Mysql\Company as MysqlCompany;
use MongoDB\Client;

class CompanyTest extends \TestCase
{
    public $client;
    public $companies;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->companies = $this->client->tesis->companies;
        $this->helper = new TestHelper();
    }

    public function test_if_company_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->companies;

        $objects = factory(MysqlCompany::class, 10)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_company_lists()
    {
        $this->callGet(route('companies.index'));
        $this->assertResponseOk();
    }

    public function test_if_company_saves()
    {
        $array = factory(MysqlCompany::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'users', 'user_id');
        $array = $this->helper->addRandomObjectToArray($array, 'currencies', 'currencies', 2);
        $array = $this->helper->addRandomObjectToArray($array, 'responsibilities', 'responsibility_id');

        $this->callPost(route('companies.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_company_show()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $company_id = (string)$company['_id'];
        $this->callGet(route('companies.show', ['company_id' => $company_id]));
        $this->assertResponseOk();
    }

    public function test_if_company_update()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlCompany::class)->make()->toArray();
        unset($array['name']);

        $array = $this->helper->addRandomObjectToArray($array, 'users', 'user_id');
        $array = $this->helper->addRandomObjectToArray($array, 'currencies', 'currencies', 2);
        $array = $this->helper->addRandomObjectToArray($array, 'responsibilities', 'responsibility_id');

        $this->callPatch(route('companies.update', ['company_id' => $company->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_company_deletes()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $company_id = (string)$company['_id'];

        $this->callDelete(route('companies.destroy', ['company_id' => $company_id]));
        $this->assertResponseOk();
    }
}
