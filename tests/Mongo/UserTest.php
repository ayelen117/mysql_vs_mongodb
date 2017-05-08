<?php

namespace tests\Mongo\UserTests;

use App\Models\Mysql\User as MysqlUser;
use MongoDB\Client;

class UserTest extends \TestCase
{
    public $client;
    public $users;

    public function __construct()
    {
        $this->client = new Client();
        $this->users = $this->client->tesis->users;
    }

    public function test_if_user_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $objects = factory(MysqlUser::class, 1000)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_user_lists()
    {
        $this->callGet(route('users.index'));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_user_saves()
    {
        $array = factory(MysqlUser::class)->make()->toArray();
        $this->callPost(route('users.store'), $array);
        $this->assertResponseStatus(201);
//        $this->dump();
    }

    public function test_if_user_show()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $user_id = (string)$user['_id'];
        $this->callGet(route('users.show', ['user_id' => $user_id]));
        $this->assertResponseOk();
//        $this->dump();
    }

    public function test_if_user_update()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $user_id = (string)$user['_id'];
        $array = factory(MysqlUser::class)->make()->toArray();
        unset($array['name']);

        $this->callPatch(route('users.update', ['user_id' => $user_id]), $array);
        $this->assertResponseOk();
//        $this->dump();
    }


    public function test_if_user_deletes()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $user_id = (string)$user['_id'];

        $this->callDelete(route('users.destroy', ['user_id' => $user_id]));
        $this->assertResponseOk();
//        $this->dump();
    }
}
