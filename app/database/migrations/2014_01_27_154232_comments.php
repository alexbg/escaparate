<?php

use Illuminate\Database\Migrations\Migration;

class Comments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
             Schema::create('comments', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id');
                $table->integer('id_user')->unsigned();
                $table->integer('id_phone')->unsigned();
                $table->text('comment');
                $table->timestamps();
                
                // Permite establecer cual va a ser la clave ajena
                // y que quieres que los elimine en cascada
                $table->foreign('id_user')
                    ->references('id')->on('users');
                    //->onDelete('cascade');
                $table->foreign('id_phone')
                    ->references('id')->on('phones');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('comments');
	}

}