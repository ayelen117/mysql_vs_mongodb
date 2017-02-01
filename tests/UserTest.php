<?php

use App\User;

class UserTest extends TestCase
{
    /**
     *
     */
    public function test_if_user_saves_with_mysql()
    {
        $objects = factory(User::class, 20)->make();
        foreach ($objects as $var) {
            User::create($var->toArray());
        }
    }
}
