<?php

namespace tests\Mongo\InventoryTests;

use App\Models\Mysql\Inventory as MysqlInventory;
use MongoDB\Client;
use App\Helpers\TestHelper;
use tests\BaseTest;

class InventoryTest extends BaseTest
{
    public $client;
    public $inventories;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->inventories = $this->client->tesis->inventories;
        $this->helper = new TestHelper();
    }

    public function test_if_inventory_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->inventories;

        $objects = factory(MysqlInventory::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_inventory_lists()
    {
        $this->callGet(route('inventories.index'));
        $this->assertResponseOk();
    }

    public function test_if_inventory_saves()
    {
        $array = factory(MysqlInventory::class)->make()->toArray();
        $this->callPost(route('inventories.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_inventory_show()
    {
        $inventory = $this->inventories->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('inventories.show', ['inventory_id' => $inventory->_id]));
        $this->assertResponseOk();
    }

    public function test_if_inventory_update()
    {
        $inventory = $this->inventories->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlInventory::class)->make()->toArray();
        $this->callPatch(route('inventories.update', ['inventory_id' => $inventory->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_inventory_deletes()
    {
        $inventory = $this->inventories->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('inventories.destroy', ['inventory_id' => $inventory->_id]));
        $this->assertResponseOk();
    }
}
