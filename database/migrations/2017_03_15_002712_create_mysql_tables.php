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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',96);
            $table->enum('status', ['activated', 'suspended', 'redeem']);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('abbreviation',5);
            $table->text('description');
            $table->string('cuit',11);
			$table->string('legal_name', 50)->nullable();
            $table->string('street_name',96);
            $table->integer('street_number');
            $table->bigInteger('responsibility_id')->unsigned()->nullable();
			$table->foreign('responsibility_id')->references('id')->on('responsibilities')->onDelete('cascade');
            $table->string('phone');
            $table->enum('fiscal_ws', ['', 'wsfe', 'wsmtxca']);
            $table->enum('fiscal_ws_status',['','waiting','ok']);
            $table->timestamps();
        });
        
		Schema::create('categories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->bigInteger('parent_id')->nullable();
			$table->timestamps();
		});
		
        Schema::create('company_currency', function (Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->bigInteger('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->change();
            $table->float('differential_percent');
            $table->boolean('enabled');
            $table->timestamps();
        });
	
		Schema::create('pricelists', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->float('percent_price');
			$table->float('percent_subdist');
			$table->float('percent_prevent');
			$table->timestamps();
		});
	
		Schema::create('entities', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->bigInteger('author_id')->unsigned();
			$table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('identification_id')->unsigned();
			$table->foreign('identification_id')->references('id')->on('identifications')->onDelete('cascade');
			$table->bigInteger('identification_number')->unsigned();
			$table->string('contact_name',96);
			$table->string('street_name',96);
			$table->integer('street_number')->unsigned();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->text('additional_info');
			$table->string('email',96);
			$table->string('phone');
			$table->bigInteger('pricelist_id')->unsigned();
			$table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('cascade');
			$table->enum('entity_type',['client','supplier','employee','creditor','subdist','prevent','seller']);
			$table->bigInteger('responsibility_id')->unsigned();
			$table->foreign('responsibility_id')->references('id')->on('responsibilities')->onDelete('cascade');
			$table->string('observations');
			$table->boolean('has_account')->default(true);
			$table->float('balance');
			$table->dateTime('balance_at');
			$table->timestamps();
		});
	
		Schema::create('documents', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('parent_id')->unsigned()->nullable();
			$table->foreign('parent_id')->references('id')->on('documents')->onDelete('cascade');
			$table->bigInteger('author_id')->unsigned();
			$table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->bigInteger('entity_id')->unsigned();
			$table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
			$table->bigInteger('seller_id')->unsigned();
			$table->foreign('seller_id')->references('id')->on('entities')->onDelete('cascade');
			$table->bigInteger('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
			$table->bigInteger('receipt_id')->unsigned();
			$table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
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
		
			$table->enum('status',['draft','failed','queued','confirmed'])->default('draft');
		});
		
		Schema::create('products', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->text('description');
			$table->string('barcode',96);
//            $table->unique(['barcode', 'company_id']);
			$table->enum('product_type',['service','product']);
			$table->integer('duration')->unsigned();
			$table->enum('stock_type',['disabled','negative','positive']);
			$table->float('replacement_cost');
			$table->bigInteger('author_id')->unsigned();
			$table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->bigInteger('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->bigInteger('tax_id')->unsigned();
			$table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
			$table->bigInteger('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
			$table->integer('stock');
			$table->integer('stock_alert')->unsigned();
			$table->integer('stock_desired')->unsigned();
			$table->float('high');
			$table->float('width');
			$table->float('length');
			$table->float('weight');
			$table->float('weight_element');
			$table->timestamps();
		});
	
		Schema::create('transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('entity_id')->unsigned();
			$table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
			$table->dateTime('due_date');
			$table->float('amount');
			$table->bigInteger('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
			$table->string('observations');
			$table->timestamps();
		});
		
        Schema::create('details', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('document_id')->unsigned();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->integer('qty')->unsigned();
			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->float('calculated_inventory_cost');
            $table->float('net_unit_price', 15, 2);
            $table->float('final_unit_price', 15, 2);
            $table->float('commission');
            $table->timestamps();     
        });

        Schema::create('document_document', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('document_id')->unsigned();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
			$table->bigInteger('parent_document_id')->unsigned();
			$table->foreign('parent_document_id')->references('id')->on('documents')->onDelete('cascade');
			$table->bigInteger('transaction_id')->unsigned();
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade')->change();
            $table->timestamps();
        });

        Schema::create('document_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('document_id')->unsigned();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
			$table->bigInteger('transaction_id')->unsigned();
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('entity_entity', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('entity_id')->unsigned();
			$table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
			$table->bigInteger('parent_entity_id')->unsigned();
			$table->foreign('parent_entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('fiscalpos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->enum('pos_type',['manual','fiscal_printer','electronic']);
            $table->string('alias');
            $table->boolean('status');
			$table->bigInteger('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->boolean('default')->default(false);
            $table->string('fiscaltoken',1000);
            $table->timestamps();     
        });
        
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('qty');
            $table->integer('current_stock_qty');
			$table->bigInteger('document_id')->unsigned();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->bigInteger('detail_id')->unsigned();
			$table->foreign('detail_id')->references('id')->on('details')->onDelete('cascade');
            $table->float('unit_price', 8, 2);
            $table->float('total_price', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();     
        });

        Schema::create('pricelist_product', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->bigInteger('pricelist_id')->unsigned();
			$table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('cascade');
            $table->float('price');
            $table->float('percent_subdist');
            $table->float('percent_prevent');
            $table->unique(array('product_id', 'pricelist_id'));
            $table->timestamps();     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('pricelist_product');
        Schema::dropIfExists('inventories');
		Schema::dropIfExists('fiscalpos');
		Schema::dropIfExists('entity_entity');
		Schema::dropIfExists('document_transaction');
		Schema::dropIfExists('document_document');
		Schema::dropIfExists('details');
        Schema::dropIfExists('transactions');
		Schema::dropIfExists('products');
		Schema::dropIfExists('documents');
		Schema::dropIfExists('entities');
		Schema::dropIfExists('pricelists');
		Schema::dropIfExists('company_currency');
		Schema::dropIfExists('categories');
		Schema::dropIfExists('companies');
    }
}
