<?php

use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('users', function($table)
            {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('username');
                $table->string('password');
                $table->string('address');
                $table->integer('phone');
                $table->string('date');
                
                // MODIFICADO EN CALSE
                $table->string('url');
                $table->integer('sex');
                $table->string('nif');
                $table->string('city');
                $table->string('country');
                $table->string('others');
                $table->string('language');
                //HASTA AQUI
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
            Schema::drop('users');
	}

}