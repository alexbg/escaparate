<?php

use Illuminate\Database\Migrations\Migration;

class Phones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('phones', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id');
                $table->string('name')->unique();
                $table->integer('id_brand')->unsigned();
                $table->string('image');
                $table->string('so');
                $table->string('cpu');
                $table->string('ram');
                $table->string('camera');
                $table->timestamps();
                
                // Permite establecer cual va a ser la clave ajena
                // y que quieres que los elimine en cascada
                $table->foreign('id_brand')
                    ->references('id')->on('brands')
                    ->onDelete('cascade');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('phones');
	}

}