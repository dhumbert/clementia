<?php

class Add_Downgrade_Date {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        try {
            Schema::drop('pending_downgrades');
        } catch (Exception $e) {
            // do nothing
        }

		Schema::table('users', function($table) {
            $table->date('downgrade_date')->nullable();
            $table->integer('downgrade_role_id')->unsigned()->nullable();

            $table->foreign('downgrade_role_id')->references('id')->on('roles');
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
            $table->drop('downgrade_date');
            $table->drop('downgrade_role_id');
        });
	}

}