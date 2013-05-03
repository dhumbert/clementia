<?php

class Create_Sites {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sites', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
            $table->string('domain')->unique();
            $table->timestamps();
        });

        Schema::table('tests', function($table)
        {
            $table->drop_foreign('tests_user_id_foreign');
            $table->integer('site_id')->unsigned();
            $table->foreign('site_id')->references('id')->on('sites')->on_delete('cascade');
            $table->drop_column('user_id');
        });

        Schema::table('roles', function($table)
        {
            $table->integer('allowed_sites')->unsigned()->nullable();
            $table->integer('tests_per_site')->unsigned()->nullable();
            $table->drop_column('allowed_tests');
        });
    }

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('sites', function($table)
        {
            $table->drop_foreign('sites_user_id_foreign');
        });

        Schema::table('tests', function($table)
        {
            $table->drop_foreign('tests_site_id_foreign');
            $table->drop_column('site_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
        });

        Schema::drop('sites');

        Schema::table('roles', function($table)
        {
            $table->drop_column('allowed_sites');
            $table->drop_column('tests_per_site');
            $table->integer('allowed_tests')->unsigned()->nullable();
        });
	}

}