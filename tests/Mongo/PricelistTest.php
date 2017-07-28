<?php

namespace tests\Mongo\PricelistTests;

use App\Models\Mysql\Pricelist as MysqlPricelist;
use MongoDB\Client;
use App\Helpers\TestHelper;

class PricelistTest extends \TestCase
{
    public $client;
    public $pricelists;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->pricelists = $this->client->tesis->pricelists;
        $this->helper = new TestHelper();
    }

    public function test_if_pricelist_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->pricelists;

        $objects = factory(MysqlPricelist::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_pricelist_lists()
    {
        $this->callGet(route('pricelists.index'));
        $this->assertResponseOk();
    }

    public function test_if_pricelist_saves()
    {
        $array = factory(MysqlPricelist::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPost(route('pricelists.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_pricelist_show()
    {
        $pricelist = $this->pricelists->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('pricelists.show', ['pricelist_id' => $pricelist->_id]));
        $this->assertResponseOk();
    }

    public function test_if_pricelist_update()
    {
        $pricelist = $this->pricelists->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlPricelist::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPatch(route('pricelists.update', ['pricelist_id' => $pricelist->_id]), $array);
        $this->assertResponseOk();
    }


    public function test_if_pricelist_deletes()
    {
        $pricelist = $this->pricelists->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('pricelists.destroy', ['pricelist_id' => $pricelist->_id]));
        $this->assertResponseOk();
    }
}
