<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMysqlTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',96);
            $table->enum('status', ['activated', 'suspended', 'redeem']);
            $table->bigInteger('user_id')->unsigned()->references('id')->on('users');
            $table->string('abbreviation',5);
            $table->text('description');
            $table->string('cuit',11);
            $table->string('street_name',96);
            $table->integer('street_number');
            $table->integer('responsibility_id')->unsigned();
            $table->string('phone');
            $table->enum('fiscal_ws', ['', 'wsfe', 'wsmtxca']);
            $table->enum('fiscal_ws_status',['','waiting','ok']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('company_currency', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->integer('currency_id')->unsigned()->references('id')->on('currencies');
            $table->float('differential_percent');
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_iso');
            $table->string('code_afip',3);
            $table->string('symbol',10);
            $table->float('quotation_usd')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('document_id')->unsigned()->references('id')->on('documents');
            $table->integer('qty')->unsigned();
            $table->bigInteger('product_id')->unsigned()->references('id')->on('products');
            $table->float('calculated_inventory_cost');
            $table->float('net_unit_price', 15, 2);
            $table->float('final_unit_price', 15, 2);
            $table->float('commission');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('document_document', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->references('id')->on('documents');
            $table->integer('parent_document_id')->references('id')->on('documents');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('document_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->references('id')->on('documents');
            $table->integer('transaction_id')->references('id')->on('transactions');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id')->unsigned()->references('id')->on('users');
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->bigInteger('entity_id')->unsigned()->references('id')->on('entities');
            $table->bigInteger('seller_id')->unsigned();
            $table->integer('currency_id')->unsigned()->references('id')->on('currencies');
            $table->integer('receipt_id')->unsigned()->references('id')->on('receipts');
            $table->enum('section', ['sales', 'purchases'])->nullable();
            $table->enum('receipt_type', ['', 'invoice', 'credit', 'debit', 'order_sell', 'order_buy', 'quotation','zeta']);
            $table->string('receipt_volume')->nullable();
            $table->string('receipt_number')->nullable();
            $table->float('total_commission', 15, 2);
            $table->float('total_cost', 15, 2);
            $table->float('total_net_price', 15, 2);
            $table->float('total_final_price', 15, 2);
            $table->date('emission_date');
            $table->string('cae', 14);
            $table->date('cae_expiration_date');
            $table->text('observation');
            $table->text('fiscal_observation');
            $table->boolean('canceled')->default(false);
            $table->boolean('show_amounts')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status',['draft','failed','queued','confirmed'])->default('draft');
        });

        Schema::create('entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',96);
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->bigInteger('author_id')->unsigned()->references('id')->on('users');
            $table->integer('identification_id')->unsigned()->references('id')->on('identifications');
            $table->bigInteger('identification_number')->unsigned();
            $table->string('contact_name',96);
            $table->string('street_name',96);
            $table->integer('street_number')->unsigned();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('additional_info');
            $table->string('email',96);
            $table->string('phone');
            $table->bigInteger('pricelist_id')->unsigned()->references('id')->on('pricelists');
            $table->enum('entity_type',['client','supplier','employee','creditor','subdist','prevent','seller']);
            $table->integer('responsibility_id')->unsigned()->references('id')->on('responsibilities');
            $table->string('observations');
            $table->boolean('has_account')->default(true);
            $table->float('balance');
            $table->dateTime('balance_at');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('entity_entity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_id')->references('id')->on('entities');
            $table->integer('parent_entity_id')->references('id')->on('entities');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fiscalpos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->enum('pos_type',['manual','fiscal_printer','electronic']);
            $table->string('alias');
            $table->boolean('status');
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->boolean('default');
            $table->string('fiscaltoken',1000);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('identifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_afip',2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty');
            $table->integer('current_stock_qty');
            $table->bigInteger('document_id')->unsigned()->references('id')->on('documents');
            $table->bigInteger('product_id')->unsigned()->references('id')->on('products');
            $table->integer('detail_id')->unsigned()->references('id')->on('details');
            $table->float('unit_price', 8, 2);
            $table->float('total_price', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pricelist_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->bigInteger('pricelist_id');
            $table->float('price');
            $table->float('percent_subdist');
            $table->float('percent_prevent');
            $table->unique(array('product_id', 'pricelist_id'));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pricelists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',96);
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->float('percent_price');
            $table->float('percent_subdist');
            $table->float('percent_prevent');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',96);
            $table->text('description');
            $table->string('barcode',96);
            $table->unique(['barcode', 'company_id']);
            $table->enum('product_type',['service','product']);
            $table->integer('duration')->unsigned();
            $table->enum('stock_type',['disabled','negative','positive']);
            $table->float('replacement_cost');
            $table->bigInteger('author_id')->unsigned()->references('id')->on('users');
            $table->bigInteger('company_id')->unsigned()->references('id')->on('companies');
            $table->integer('category_id')->unsigned();
            $table->integer('tax_id')->unsigned()->references('id')->on('taxes');
            $table->integer('currency_id')->unsigned()->references('id')->on('currencies');
            $table->integer('stock');
            $table->integer('stock_alert')->unsigned();
            $table->integer('stock_desired')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_afip',3);
            $table->string('receipt_type',96);
            $table->string('letter',2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('responsibilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_afip',2);
            $table->string('abbreviation');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('entity_id')->unsigned()->references('id')->on('entities')->onDelete('cascade');
            $table->dateTime('due_date');
            $table->float('amount');
            $table->integer('currency_id')->unsigned()->references('id')->on('currencies');
            $table->string('observations');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('measures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_afip',3);
            $table->string('short_name',15);
            $table->string('measure_type',96);
            $table->float('factor');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',96);
            $table->string('code_afip',3);
            $table->float('percent_value');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_currency');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('details');
        Schema::dropIfExists('document_document');
        Schema::dropIfExists('document_transaction');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('entities');
        Schema::dropIfExists('entity_entity');
        Schema::dropIfExists('fiscalpos');
        Schema::dropIfExists('identifications');
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('pricelist_product');
        Schema::dropIfExists('pricelists');
        Schema::dropIfExists('products');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('responsibilities');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('taxes');
    }
}
