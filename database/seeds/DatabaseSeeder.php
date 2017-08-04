<?php

use Illuminate\Database\Seeder;
use MongoDB\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call('MysqlSeed');
        $this->call('MongoSeed');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
