<?php

class Denormalize_Test_Table_To_Track_Passing_Status {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests', function($table){
			$table->boolean('passing');
			$table->date('last_run')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tests', function($table){
			$table->drop_column('passing');
			$table->drop_column('last_run');
		});
	}

}