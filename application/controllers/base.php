<?php

class Base_Controller extends Controller 
{
	
	public $layout = 'layouts.common';

	public function __construct()
	{
		// POST and PUT methods should always have CSRF tokens
		$this->filter('before', 'csrf')->on(array('post', 'put'));

		// assets
		Asset::container('footer')->add('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
		Asset::container('footer')->add('bootstrap-js', 'js/bootstrap.min.js');
		Asset::container('footer')->add('application-js', 'js/application.js');
		Asset::add('bootstrap-css', 'css/bootstrap.min.css');
		Asset::add('style', 'css/style.css');
		parent::__construct();
	}

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}