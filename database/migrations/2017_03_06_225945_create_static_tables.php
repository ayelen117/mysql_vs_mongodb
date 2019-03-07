<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('currencies', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_iso');
			$table->string('code_afip',3);
			$table->string('symbol',10);
			$table->float('quotation_usd')->nullable();
			$table->timestamps();
		});
	
		Schema::create('receipts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_afip',3);
			$table->string('receipt_type',96);
			$table->string('letter',2);
			$table->timestamps();
		});
	
		Schema::create('responsibilities', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_afip',2);
			$table->string('abbreviation');
			$table->timestamps();
		});
	
		Schema::create('identifications', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_afip',2);
			$table->timestamps();
		});
	
		Schema::create('measures', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_afip',3);
			$table->string('short_name',15);
			$table->string('measure_type',96);
			$table->float('factor');
			$table->timestamps();
		});
	
		Schema::create('taxes', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name',96);
			$table->string('code_afip',3);
			$table->float('percent_value');
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
		Schema::dropIfExists('currencies');
		Schema::dropIfExists('receipts');
		Schema::dropIfExists('responsibilities');
		Schema::dropIfExists('identifications');
		Schema::dropIfExists('measures');
		Schema::dropIfExists('taxes');
    }
}
