<?php

namespace tests\Mongo\CategoryTests;

use App\Models\Mysql\Category as MysqlCategory;
use MongoDB\Client;

class CategoryTest extends \TestCase
{
    public $client;
    public $categories;

    public function __construct()
    {
        $this->client = new Client();
        $this->categories = $this->client->tesis->categories;
    }

    public function test_if_category_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->categories;

        $objects = factory(MysqlCategory::class, 10)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_category_lists()
    {
        $this->callGet(route('categories.index'));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_category_saves()
    {
        $array = factory(MysqlCategory::class)->make()->toArray();
        $this->callPost(route('categories.store'), $array);
        $this->assertResponseStatus(201);
//        $this->dump();
    }

    public function test_if_category_show()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $category_id = (string)$category['_id'];
        $this->callGet(route('categories.show', ['category_id' => $category_id]));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_category_update()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $category_id = (string)$category['_id'];
        $array = factory(MysqlCategory::class)->make()->toArray();

        $this->callPatch(route('categories.update', ['category_id' => $category_id]), $array);
        $this->assertResponseOk();
//        $this->dump();
    }


    public function test_if_category_deletes()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $category_id = (string)$category['_id'];

        $this->callDelete(route('categories.destroy', ['category_id' => $category_id]));
        $this->assertResponseOk();
//        $this->dump();
    }
}
