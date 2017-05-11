<?php

namespace tests\Mongo\CurrencyTests;

use MongoDB\Client;

class CurrencyTest extends \TestCase
{
    public $client;
    public $currencies;

    public function __construct()
    {
        $this->client = new Client();
        $this->currencies = $this->client->tesis->currencies;
    }

    public function test_if_currency_lists()
    {
        $this->callGet(route('currencies.index'));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_currency_show()
    {
        $currency = $this->currencies->findOne([], ['sort' => ['_id' => -1],]);
        $currency_id = (string)$currency['_id'];
        $this->callGet(route('currencies.show', ['currency_id' => $currency_id]));
        $this->assertResponseOk();
//        $this->dump();
    }
}
