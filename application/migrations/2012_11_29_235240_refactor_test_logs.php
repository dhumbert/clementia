<?php

class Refactor_Test_Logs {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('testlogs', 'test_logs');
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::rename('test_logs', 'testlogs');
	}

}