<?php

namespace tests\Mongo\UserTests;

use App\Models\Mysql\User as MysqlUser;
use MongoDB\Client;
use tests\BaseTest;

class UserTest extends BaseTest
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

        $objects = factory(MysqlUser::class, 2)->make()->toArray();
        $collection->insertMany($objects);
    }

    /*** integradores ***/

    public function test_if_user_lists()
    {
        $this->callGet(route('users.index'));
        $this->assertResponseOk();
    }

    public function test_if_user_saves()
    {
        $array = factory(MysqlUser::class)->make()->toArray();
        $this->callPost(route('users.store'), $array);
        $this->assertResponseStatus(201);
    }

    public function test_if_user_show()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $this->callGet(route('users.show', ['user_id' => $user->_id]));
        $this->assertResponseOk();
    }

    public function test_if_user_update()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $array = factory(MysqlUser::class)->make()->toArray();
        unset($array['name']);

        $this->callPatch(route('users.update', ['user_id' => $user->_id]), $array);
        $this->assertResponseOk();
    }


    public function test_if_user_deletes()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $this->callDelete(route('users.destroy', ['user_id' => $user->_id]));
        $this->assertResponseOk();
    }
}
