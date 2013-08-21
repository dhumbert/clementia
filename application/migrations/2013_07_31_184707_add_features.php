<?php

class Add_Features {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('features', function($table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('roles_features', function($table) {
            $table->integer('role_id')->unsigned();
            $table->integer('feature_id')->unsigned();

            $table->primary(array('role_id', 'feature_id'));
            $table->foreign('role_id')->references('id')->on('roles')->on_delete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->on_delete('cascade');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('roles_features', function($table) {
            $table->drop_foreign('roles_features_role_id_foreign');
            $table->drop_foreign('roles_features_feature_id_foreign');
        });

        Schema::drop('roles_features');
		Schema::drop('features');
	}

}