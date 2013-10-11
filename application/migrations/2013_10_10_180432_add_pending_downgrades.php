<?php

class Add_Pending_Downgrades {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('downgrades', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->date('downgrade_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
            $table->foreign('role_id')->references('id')->on('roles');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('downgrades', function($table) {
           $table->drop_foreign('pending_downgrades_user_id_foreign');
           $table->drop_foreign('pending_downgrades_role_id_foreign');
        });
		Schema::drop('downgrades');
	}

}