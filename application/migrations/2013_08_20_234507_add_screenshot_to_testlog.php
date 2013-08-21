<?php

class Add_Screenshot_To_Testlog {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_logs', function($table){
           $table->string('screenshot')->nullable();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('test_logs', function($table){
            $table->drop_column('screenshot');
        });
	}

}