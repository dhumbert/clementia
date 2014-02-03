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
            $table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->integer('allowed_tests')->unsigned()->nullable();
		});

		$admin_role_id = DB::table('roles')->insert_get_id(array('name' => 'Administrator'));
		DB::table('roles')->insert(array('name' => 'Free', 'allowed_tests' => 5));

		Schema::table('users', function($table){
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->on_delete('cascade');
		});

		DB::table('users')->insert(array(
			'email' => 'test@example.com',
			'password' => '$2a$08$2P3h9/IVdkPoZvjfQHdRme/OfjFfTd1Su7EI/Rs2Sv/sp0w9mzA2S',
			'role_id' => $admin_role_id,
		));
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