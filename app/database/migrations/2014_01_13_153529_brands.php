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
            Schema::drop('brands');
	}

}