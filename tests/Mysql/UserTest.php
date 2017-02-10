<?php

namespace tests\Mysql\UserTests;

use App\Models\Mysql\User as MysqlUser;

class UserTest extends \TestCase
{
    public function test_if_user_saves_with_mysql()
    {
        $objects = factory(MysqlUser::class, 100)->make();
        $tiempo_total = 0;
        foreach ($objects as $var) {
            $tiempo_inicio = microtime(true);
            MysqlUser::create($var->toArray());
            $tiempo_fin   = microtime(true);
            $tiempo       = $tiempo_fin - $tiempo_inicio;
            $tiempo_total = $tiempo_total + $tiempo;
        }
        dump($tiempo_total);
    }
    public function test_if_user_list_with_mysql()
    {
        $users = MysqlUser::all()->toArray();
    }
}
