<?php

class Create_Test_Logs_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testlogs', function($table) {
			$table->engine = 'InnoDB';
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('test_id')->unsigned();
			$table->foreign('test_id')->references('id')->on('tests');
			$table->text('message');
			$table->boolean('passed');
			$table->timestamps();  
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('testlogs');
	}

}