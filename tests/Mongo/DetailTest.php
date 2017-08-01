<?php

namespace tests\Mongo\DetailTests;

use App\Models\Mysql\Detail as MysqlDetail;
use MongoDB\Client;
use App\Helpers\TestHelper;
use tests\BaseTest;

class DetailTest extends BaseTest
{
    public $client;
    public $details;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->details = $this->client->tesis->details;
        $this->helper = new TestHelper();
    }

    public function test_if_detail_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->details;

        $objects = factory(MysqlDetail::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_detail_lists()
    {
        $this->callGet(route('details.index'));
        $this->assertResponseOk();
    }

    public function test_if_detail_saves()
    {
        $array = factory(MysqlDetail::class)->make()->toArray();
        $this->callPost(route('details.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_detail_show()
    {
        $detail = $this->details->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('details.show', ['detail_id' => $detail->_id]));
        $this->assertResponseOk();
    }

    public function test_if_detail_update()
    {
        $detail = $this->details->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlDetail::class)->make()->toArray();
        $this->callPatch(route('details.update', ['detail_id' => $detail->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_detail_deletes()
    {
        $detail = $this->details->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('details.destroy', ['detail_id' => $detail->_id]));
        $this->assertResponseOk();
    }
}
