<?php

namespace tests\Mysql\CategoryTests;

use App\Models\Mysql\Category as MysqlCategory;

class CategoryTest extends \TestCase
{
    public function test_if_category_saves_with_mysql()
    {
        $objects = factory(MysqlCategory::class, 'mysql', 10)->make();
        foreach ($objects as $var) {
            MysqlCategory::create($var->toArray());
        }
    }
    public function test_if_category_list_with_mysql()
    {
        $categories = MysqlCategory::all()->toArray();
    }
}
