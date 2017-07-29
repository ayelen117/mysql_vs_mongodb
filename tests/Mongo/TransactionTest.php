<?php

namespace tests\Mongo\TransactionTests;

use App\Models\Mysql\Transaction as MysqlTransaction;
use MongoDB\Client;
use App\Helpers\TestHelper;

class TransactionTest extends \TestCase
{
    public $client;
    public $transactions;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->transactions = $this->client->tesis->transactions;
        $this->helper = new TestHelper();
    }

    public function test_if_transaction_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->transactions;

        $objects = factory(MysqlTransaction::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_transaction_lists()
    {
        $this->callGet(route('transactions.index'));
        $this->assertResponseOk();
    }

    public function test_if_transaction_saves()
    {
        $array = factory(MysqlTransaction::class)->make()->toArray();
        $this->callPost(route('transactions.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_transaction_show()
    {
        $transaction = $this->transactions->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('transactions.show', ['transaction_id' => $transaction->_id]));
        $this->assertResponseOk();
    }

    public function test_if_transaction_update()
    {
        $transaction = $this->transactions->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlTransaction::class)->make()->toArray();
        $this->callPatch(route('transactions.update', ['transaction_id' => $transaction->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_transaction_deletes()
    {
        $transaction = $this->transactions->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('transactions.destroy', ['transaction_id' => $transaction->_id]));
        $this->assertResponseOk();
    }
}
