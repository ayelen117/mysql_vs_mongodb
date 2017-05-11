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
        $client = new Client();

        $collection = $client->tesis->identifications;
        $identifications = config('seed.identifications');
        $collection->insertMany($identifications);

        $collection = $client->tesis->receipts;
        $receipts = config('seed.receipts');
        $collection->insertMany($receipts);

        $collection = $client->tesis->currencies;
        $currencies = config('seed.currencies');
        $collection->insertMany($currencies);

        $collection = $client->tesis->responsibilities;
        $responsibilities = config('seed.responsibilities');
        $collection->insertMany($responsibilities);
    }
}
