<?php

namespace tests\Mongo\UserTests;

use App\Models\MongoDB\User as MongoUser;
use App\Models\Mysql\User as MysqlUser;
use tests\BaseTest;
use MongoDB\Client;

class UserTest extends \TestCase
{

    public function test_if_user_saves_with_mongo()
    {
        $tiempo_total = 0;
        $objects = factory(MysqlUser::class, 100)->make();
        foreach ($objects as $var) {
            $tiempo_inicio = microtime(true);
            $user = new MongoUser();
            $user->name = $var->name;
            $user->email = $var->email;
            $user->password = $var->password;
            $user->remember_token = $var->remember_token;
            $user->save();
            $tiempo_fin   = microtime(true);
            $tiempo       = $tiempo_fin - $tiempo_inicio;
            $tiempo_total = $tiempo_total + $tiempo;
        }
        dump($tiempo_total);
    }

    public function test_if_user_insertOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $tiempo_total = 0;
        $objects = factory(MysqlUser::class, 1000)->make();
        foreach ($objects as $var) {
            $tiempo_inicio = microtime(true);

            $collection->insertOne([
                'name' => $var->name,
                'email' => $var->email,
                'password' => $var->password,
                'remember_token' => $var->remember_token,
            ]);

            $tiempo_fin   = microtime(true);
            $tiempo       = $tiempo_fin - $tiempo_inicio;
            $tiempo_total = $tiempo_total + $tiempo;
        }
        dump($tiempo_total);
    }

    public function test_if_user_insertMany_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $tiempo_total = 0;
        $objects = factory(MysqlUser::class, 1000)->make()->toArray();
        $tiempo_inicio = microtime(true);

        $collection->insertMany($objects);

        $tiempo_fin   = microtime(true);
        $tiempo       = $tiempo_fin - $tiempo_inicio;
        $tiempo_total = $tiempo_total + $tiempo;
        dump($tiempo_total);
    }

    public function test_if_user_findOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $tiempo_total = 0;
        $tiempo_inicio = microtime(true);

        $user = $collection->findOne();
        $tiempo_fin   = microtime(true);
        $tiempo       = $tiempo_fin - $tiempo_inicio;
        $tiempo_total = $tiempo_total + $tiempo;
        dump($tiempo_total);
        dump($user);
    }

    public function test_if_user_find_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $tiempo_total = 0;
        $tiempo_inicio = microtime(true);

        $users = $collection->find();
        $tiempo_fin   = microtime(true);
        $tiempo       = $tiempo_fin - $tiempo_inicio;
        $tiempo_total = $tiempo_total + $tiempo;
        dump($tiempo_total);
    }

    public function test_if_user_updateOne_with_pure_mongo()
    {
        $client = new Client();
        $collection = $client->tesis->users;

        $tiempo_total = 0;
        $tiempo_inicio = microtime(true);

        $updateResult = $collection->updateOne(
            ['name' => ['$ne' => 'Test']],
            ['$set' => ['name' => 'Aye']],
            ['limit' => 1, 'upsert' => false]
        );

        $tiempo_fin   = microtime(true);
        $tiempo       = $tiempo_fin - $tiempo_inicio;
        $tiempo_total = $tiempo_total + $tiempo;
        dump($tiempo_total);
        printf("Matched %d document(s)\n", $updateResult->getMatchedCount());
        printf("Modified %d document(s)\n", $updateResult->getModifiedCount());
    }
}
