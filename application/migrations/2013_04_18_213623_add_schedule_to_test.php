<?php

class Add_Schedule_To_Test {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests', function($table) {
			$table->boolean('autorun')->default(TRUE);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tests', function($table) {
			$table->drop_column('autorun');
		});
	}

}