<?php

namespace tests\Mongo\CompanyTests;

use App\Helpers\TestHelper;
use App\Models\Mysql\Company as MysqlCompany;
use MongoDB\Client;
use tests\BaseTest;

class CompanyTest extends BaseTest
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

        $objects = factory(MysqlCompany::class, 2)->make()->toArray();
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
        $this->callPost(route('companies.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_company_show()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('companies.show', ['company_id' => $company->_id]));
        $this->assertResponseOk();
    }

    public function test_if_company_update()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlCompany::class)->make()->toArray();
        unset($array['name']);
        $this->callPatch(route('companies.update', ['company_id' => $company->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_company_deletes()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('companies.destroy', ['company_id' => $company->_id]));
        $this->assertResponseOk();
    }
}
