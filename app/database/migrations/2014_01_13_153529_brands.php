<?php

use Illuminate\Database\Migrations\Migration;

class Brands extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('brands', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id');
                $table->string('name')->unique();
                $table->integer('id_user')->unsigned();
                $table->timestamps();
                
                // permite establecer cual va a ser la clave ajena del usuario
                /*$table->foreign('id_user')
                    ->references('id')->on('users');*/
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('brands');
	}

}