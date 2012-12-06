<?php

class Add_Token_To_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('token', 64)->nullable();
			$table->date('token_generated')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
			$table->drop_column('token');
			$table->drop_column('token_generated');
		});
	}

}