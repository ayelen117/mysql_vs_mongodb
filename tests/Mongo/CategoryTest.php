<?php

namespace tests\Mongo\CategoryTests;

use App\Models\Mysql\Category as MysqlCategory;
use MongoDB\Client;
use App\Helpers\TestHelper;

class CategoryTest extends \TestCase
{
    public $client;
    public $categories;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->categories = $this->client->tesis->categories;
        $this->helper = new TestHelper();
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
    }

    public function test_if_category_saves()
    {
        $array = factory(MysqlCategory::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPost(route('categories.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_category_show()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('categories.show', ['category_id' => $category->_id]));
        $this->assertResponseOk();
    }

    public function test_if_category_update()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlCategory::class)->make()->toArray();
        $array = $this->helper->addRandomObjectToArray($array, 'companies', 'company_id');

        $this->callPatch(route('categories.update', ['category_id' => $category->_id]), $array);
        $this->assertResponseOk();
    }


    public function test_if_category_deletes()
    {
        $category = $this->categories->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('categories.destroy', ['category_id' => $category->_id]));
        $this->assertResponseOk();
    }
}
