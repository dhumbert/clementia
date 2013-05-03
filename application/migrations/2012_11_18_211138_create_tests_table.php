<?php

class Create_Tests_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests', function($table) {
			$table->engine = 'InnoDB';
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('description', '500');
			$table->string('url', '500');
			$table->string('type', '100');
			$table->text('options');
			$table->timestamps();  
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('tests', function($table)
        {
            $table->drop_foreign('tests_user_id_foreign');
        });

		Schema::drop('tests');
	}

}