<?php

class Session_Controller extends Base_Controller 
{

	public $restful = TRUE;

	public function put_create() 
	{
		$credentials = array('username' => Input::get('email'), 'password' => Input::get('password'));

		if (Auth::attempt($credentials)) {
			return Redirect::to_route('user_profile');
		} else {
			return Redirect::back()->with('error', 'Invalid username/password combination.');
		}
	}

	public function delete_destroy() 
	{
		Auth::logout();
		return Redirect::to_route('home');
	}

}