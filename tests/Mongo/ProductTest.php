<?php

namespace tests\Mongo\ProductTests;

use App\Models\Mysql\Product as MysqlProduct;
use MongoDB\Client;
use App\Helpers\TestHelper;
use tests\BaseTest;

class ProductTest extends BaseTest
{
    public $client;
    public $products;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->products = $this->client->tesis->products;
        $this->helper = new TestHelper();
    }

    public function test_if_product_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->products;
        $objects = factory(MysqlProduct::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_product_lists()
    {
        $this->callGet(route('products.index'));
        $this->assertResponseOk();
    }

    public function test_if_product_saves()
    {
        $array = factory(MysqlProduct::class)->make()->toArray();
        $this->callPost(route('products.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_product_show()
    {
        $product = $this->products->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('products.show', ['product_id' => $product->_id]));
        $this->assertResponseOk();
    }

    public function test_if_product_update()
    {
        $product = $this->products->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlProduct::class)->make()->toArray();
        $this->callPatch(route('products.update', ['product_id' => $product->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_product_deletes()
    {
        $product = $this->products->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('products.destroy', ['product_id' => $product->_id]));
        $this->assertResponseOk();
    }
}
