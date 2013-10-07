<?php

class Add_Card_To_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
            $table->string('card_last_4')->nullable();
            $table->string('card_type')->nullable();
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
            $table->drop_column('card_last_4');
            $table->drop_column('card_type');
        });
	}

}