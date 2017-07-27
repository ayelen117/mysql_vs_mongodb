<?php

namespace tests\Mongo\FiscalposTests;

use App\Models\Mysql\Fiscalpos as MysqlFiscalpos;
use MongoDB\Client;
use App\Helpers\TestHelper;

class FiscalposTest extends \TestCase
{
    public $client;
    public $fiscalpos;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->fiscalpos = $this->client->tesis->fiscalpos;
        $this->helper = new TestHelper();
    }

    public function test_if_fiscalpos_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->fiscalpos;

        $objects = factory(MysqlFiscalpos::class, 10)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_fiscalpos_lists()
    {
        $this->callGet(route('fiscalpos.index'));
        $this->assertResponseOk();
    }

    public function test_if_fiscalpos_saves()
    {
        $array = factory(MysqlFiscalpos::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPost(route('fiscalpos.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_fiscalpos_show()
    {
        $fiscalpos = $this->fiscalpos->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('fiscalpos.show', ['fiscalpos_id' => $fiscalpos->_id]));
        $this->assertResponseOk();
    }

    public function test_if_fiscalpos_update()
    {
        $fiscalpos = $this->fiscalpos->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlFiscalpos::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPatch(route('fiscalpos.update', ['fiscalpos_id' => $fiscalpos->_id]), $array);
        $this->assertResponseOk();
    }


    public function test_if_fiscalpos_deletes()
    {
        $fiscalpos = $this->fiscalpos->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('fiscalpos.destroy', ['fiscalpos_id' => $fiscalpos->_id]));
        $this->assertResponseOk();
    }
}
