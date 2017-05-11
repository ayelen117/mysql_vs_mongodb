<?php

namespace tests\Mongo\ReceiptTests;

use MongoDB\Client;

class ReceiptTest extends \TestCase
{
    public $client;
    public $receipts;

    public function __construct()
    {
        $this->client = new Client();
        $this->receipts = $this->client->tesis->receipts;
    }

    public function test_if_receipt_lists()
    {
        $this->callGet(route('receipts.index'));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_receipt_show()
    {
        $receipt = $this->receipts->findOne([], ['sort' => ['_id' => -1],]);
        $receipt_id = (string)$receipt['_id'];
        $this->callGet(route('receipts.show', ['receipt_id' => $receipt_id]));
        $this->assertResponseOk();
//        $this->dump();
    }
}
