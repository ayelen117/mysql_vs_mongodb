<?php

namespace tests\Mongo\ResponsibilityTests;

use MongoDB\Client;
use tests\BaseTest;

class ResponsibilityTest extends BaseTest
{
    public $client;
    public $responsibilities;

    public function __construct()
    {
        $this->client = new Client();
        $this->responsibilities = $this->client->tesis->responsibilities;
    }

    public function test_if_responsibility_lists()
    {
        $this->callGet(route('responsibilities.index'));
        $this->assertResponseOk();
    }

    public function test_if_responsibility_show()
    {
        $responsibility = $this->responsibilities->findOne([], ['sort' => ['_id' => -1],]);
        $responsibility_id = (string)$responsibility['_id'];
        $this->callGet(route('responsibilities.show', ['responsibility_id' => $responsibility_id]));
        $this->assertResponseOk();
    }
}
