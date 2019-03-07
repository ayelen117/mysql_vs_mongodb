<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('entity_id')->nullable();
            $table->string('password');
            $table->boolean('activated')->default(0);
            $table->boolean('banned')->default(0);
            $table->boolean('super_admin')->default(0);
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->rememberToken();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
