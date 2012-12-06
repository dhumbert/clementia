<?php

class Create_Roles {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function($table){
			$table->increments('id');
			$table->string('name');
			$table->integer('allowed_tests')->unsigned()->nullable();
		});

		DB::table('roles')->insert(array('name' => 'Administrator'));
		DB::table('roles')->insert(array('name' => 'Free', 'allowed_tests' => 5));

		Schema::table('users', function($table){
			$table->integer('role_id')->unsigned();
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
		Schema::table('users', function($table){
			$table->drop_foreign('users_role_id_foreign');
			$table->drop_column('role_id');
		});

		Schema::drop('roles');
	}

}