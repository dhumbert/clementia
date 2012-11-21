<?php

class Fix_Foreign_Key_Constraints {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests', function($table) {
			// first drop old constraint
			$table->drop_foreign('tests_user_id_foreign');
			// then create new one with proper cascade behavior
			$table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
		});

		Schema::table('testlogs', function($table) {
			// first drop old constraint
			$table->drop_foreign('testlogs_test_id_foreign');
			// then create new one with proper cascade behavior
			$table->foreign('test_id')->references('id')->on('tests')->on_delete('cascade');
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
			// first drop new constraint
			$table->drop_foreign('tests_user_id_foreign');
			// then create new one without proper cascade behavior
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('testlogs', function($table) {
			// first drop new constraint
			$table->drop_foreign('testlogs_test_id_foreign');
			// then create new one without proper cascade behavior
			$table->foreign('test_id')->references('id')->on('tests');
		});
	}

}