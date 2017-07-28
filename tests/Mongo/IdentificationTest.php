<?php

namespace tests\Mongo\IdentificationTests;

use MongoDB\Client;

class IdentificationTest extends \TestCase
{
    public $client;
    public $identifications;

    public function __construct()
    {
        $this->client = new Client();
        $this->identifications = $this->client->tesis->identifications;
    }

    public function test_if_identification_lists()
    {
        $this->callGet(route('identifications.index'));
        $this->assertResponseOk();
    }

    public function test_if_identification_show()
    {
        $identification = $this->identifications->findOne([], ['sort' => ['_id' => -1],]);
        $identification_id = (string)$identification['_id'];
        $this->callGet(route('identifications.show', ['identification_id' => $identification_id]));
        $this->assertResponseOk();
    }
}
