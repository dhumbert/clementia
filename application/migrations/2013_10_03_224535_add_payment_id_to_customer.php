<?php

class Add_Payment_Id_To_Customer {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('payment_gateway_id')->nullable();
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
            $table->drop_column('payment_gateway_id');
        });
    }

}