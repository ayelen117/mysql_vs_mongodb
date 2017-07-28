<?php

namespace tests\Mongo\EntityTests;

use App\Models\Mysql\Entity as MysqlEntity;
use MongoDB\Client;
use App\Helpers\TestHelper;

class EntityTest extends \TestCase
{
    public $client;
    public $entities;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->entities = $this->client->tesis->entities;
        $this->helper = new TestHelper();
    }

    public function test_if_entity_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->entities;

        $objects = factory(MysqlEntity::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_entity_lists()
    {
        $this->callGet(route('entities.index'));
        $this->assertResponseOk();
    }

    public function test_if_entity_saves()
    {
        $array = factory(MysqlEntity::class)->make()->toArray();
        $this->callPost(route('entities.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_entity_show()
    {
        $entity = $this->entities->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('entities.show', ['entity_id' => $entity->_id]));
        $this->assertResponseOk();
    }

    public function test_if_entity_update()
    {
        $entity = $this->entities->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlEntity::class)->make()->toArray();
        $this->callPatch(route('entities.update', ['entity_id' => $entity->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_entity_deletes()
    {
        $entity = $this->entities->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('entities.destroy', ['entity_id' => $entity->_id]));
        $this->assertResponseOk();
    }
}
