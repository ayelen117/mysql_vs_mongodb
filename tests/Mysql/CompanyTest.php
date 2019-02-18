<?php

namespace tests\Mysql\CompanyTests;

use App\Models\Mysql\Company as MysqlCompany;

class CompanyTest extends \TestCase
{
    public function test_if_company_saves_with_mysql()
    {
        $objects = factory(MysqlCompany::class, 'mysql', 10)->make();
        foreach ($objects as $var) {
            MysqlCompany::create($var->toArray());
        }
    }
    public function test_if_company_list_with_mysql()
    {
        $companies = MysqlCompany::all()->toArray();
    }
}
