<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Client;

class CreateMongodbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $client = new Client(config('database.mongodb.url'));
        $tables = ['categories', 'companies', 'company_currency', 'currencies', 'details', 'document_document',
                   'document_transaction', 'documents', 'entities', 'entity_entity', 'fiscalpos', 'identifications',
                   'inventories', 'pricelist_product', 'pricelists', 'products', 'receipts', 'responsibilities',
                   'transactions'];

        foreach ($tables as $table){
            $client->tesis->createCollection(
                $table,
                array(
                    'autoIndexId' => true,
                    //                'validator' => true,
                    //                'validationLevel' => true,
                    //                'validationAction' => true,
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $client = new Client(config('database.mongodb.url'));
        $tables = ['categories', 'companies', 'company_currency', 'currencies', 'details', 'document_document',
                   'document_transaction', 'documents', 'entities', 'entity_entity', 'fiscalpos', 'identifications',
                   'inventories', 'pricelist_product', 'pricelists', 'products', 'receipts', 'responsibilities',
                   'transactions'];

        foreach ($tables as $table) {
            $client->tesis->$table->drop();
        }
    }
}
