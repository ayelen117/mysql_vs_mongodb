<?php

namespace tests\Mongo\CompanyTests;

use App\Models\Mysql\Company as MysqlCompany;
use MongoDB\Client;

class CompanyTest extends \TestCase
{
    public $client;
    public $companies;

    public function __construct()
    {
        $this->client = new Client();
        $this->companies = $this->client->tesis->companies;
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
//        $this->dump();
    }

    public function test_if_company_saves()
    {
        $array = factory(MysqlCompany::class)->make()->toArray();
        $this->callPost(route('companies.store'), $array);
        $this->assertResponseStatus(201);
//        $this->dump();
    }

    public function test_if_company_show()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $company_id = (string)$company['_id'];
        $this->callGet(route('companies.show', ['company_id' => $company_id]));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_company_update()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $company_id = (string)$company['_id'];
        $array = factory(MysqlCompany::class)->make()->toArray();
        unset($array['name']);

        $this->callPatch(route('companies.update', ['company_id' => $company_id]), $array);
        $this->assertResponseOk();
//        $this->dump();
    }


    public function test_if_company_deletes()
    {
        $company = $this->companies->findOne([], ['sort' => ['_id' => -1],]);
        $company_id = (string)$company['_id'];

        $this->callDelete(route('companies.destroy', ['company_id' => $company_id]));
        $this->assertResponseOk();
//        $this->dump();
    }
}
