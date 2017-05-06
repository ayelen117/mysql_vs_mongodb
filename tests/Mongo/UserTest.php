<?php

namespace tests\Mongo\UserTests;

use App\Models\MongoDB\User as MongoUser;
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

    public function test_if_user_saves_with_mongo()
    {
        $objects = factory(MysqlUser::class, 100)->make();
        foreach ($objects as $var) {
            $user = new MongoUser();
            $user->name = $var->name;
            $user->email = $var->email;
            $user->password = $var->password;
            $user->remember_token = $var->remember_token;
            $user->save();
        }
    }

    public function test_if_user_insertOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $objects = factory(MysqlUser::class, 1000)->make();
        foreach ($objects as $var) {

            $collection->insertOne([
                'name' => $var->name,
                'email' => $var->email,
                'password' => $var->password,
                'remember_token' => $var->remember_token,
            ]);
        }
    }

    public function test_if_user_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $objects = factory(MysqlUser::class, 1000)->make()->toArray();
        $collection->insertMany($objects);
    }

    public function test_if_user_findOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;
        $user = $collection->findOne();
    }

    public function test_if_user_find_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;
        $users = $collection->find();
        foreach($users as $user) {
            var_dump($user);
        };
    }

    public function test_if_user_updateOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $updateResult = $collection->updateOne(
            ['name' => ['$ne' => 'Test']],
            ['$set' => ['name' => 'Aye']],
            ['limit' => 1, 'upsert' => false]
        );

        printf("Matched %d document(s)\n", $updateResult->getMatchedCount());
        printf("Modified %d document(s)\n", $updateResult->getModifiedCount());
    }

     /*** integradores ***/

    public function test_if_saves()
    {
        $array = factory(MysqlUser::class)->make()->toArray();
        $this->callPost(route('users.store'), $array);
        $this->dump();
    }

    public function test_if_lists()
    {
        $response = $this->callGet(route('users.index'));
        $this->dump();
    }

    public function test_if_show()
    {
        $user = $this->users->findOne([], ['sort' => ['_id' => -1],]);
        $user_id = (string)$user['_id'];
        $this->callGet(route('users.show', ['user_id' => $user_id]));
        $this->dump();
    }

}
