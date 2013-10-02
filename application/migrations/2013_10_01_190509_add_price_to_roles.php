<?php

class Add_Price_To_Roles {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('roles', function($table) {
            $table->decimal('price', 5, 2);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('roles', function($table) {
            $table->drop_column('price');
        });
	}

}