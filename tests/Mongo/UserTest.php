<?php

namespace tests\Mongo\UserTests;

use App\Models\MongoDB\User as MongoUser;
use App\Models\Mysql\User as MysqlUser;
use tests\BaseTest;

class UserTest extends \TestCase
{

    public function test_if_user_saves_with_mongo()
    {
        $tiempo_total = 0;
        $objects = factory(MysqlUser::class, 100)->make();
        foreach ($objects as $var) {
            $tiempo_inicio = microtime(true);
            MongoUser::create($var->toArray());
//            $user = new MongoUser();
//            $user->name = $var->name;
//            $user->email = $var->email;
//            $user->password = $var->password;
//            $user->remember_token = $var->remember_token;
//            $user->save();
            $tiempo_fin   = microtime(true);
            $tiempo       = $tiempo_fin - $tiempo_inicio;
            $tiempo_total = $tiempo_total + $tiempo;
        }
        dump($tiempo_total);
    }
}
