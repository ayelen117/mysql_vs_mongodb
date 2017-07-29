<?php

namespace tests\Mongo\DocumentTests;

use App\Models\Mysql\Document as MysqlDocument;
use MongoDB\Client;
use App\Helpers\TestHelper;

class DocumentTest extends \TestCase
{
    public $client;
    public $documents;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->documents = $this->client->tesis->documents;
        $this->helper = new TestHelper();
    }

    public function test_if_document_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->documents;

        $objects = factory(MysqlDocument::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_document_lists()
    {
        $this->callGet(route('documents.index'));
        $this->assertResponseOk();
    }

    public function test_if_document_saves()
    {
        $array = factory(MysqlDocument::class)->make()->toArray();
        $this->callPost(route('documents.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_document_show()
    {
        $document = $this->documents->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('documents.show', ['document_id' => $document->_id]));
        $this->assertResponseOk();
    }

    public function test_if_document_update()
    {
        $document = $this->documents->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlDocument::class)->make()->toArray();
        $this->callPatch(route('documents.update', ['document_id' => $document->_id]), $array);
        $this->assertResponseOk();
    }

    public function test_if_document_deletes()
    {
        $document = $this->documents->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('documents.destroy', ['document_id' => $document->_id]));
        $this->assertResponseOk();
    }
}
