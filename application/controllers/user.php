<?php

class User_Controller extends Base_Controller 
{

	public $restful = TRUE;

	public function get_index() 
	{
		$user = Auth::user();
		if (!$user) {
			return Response::error('404');
		} else {
			$this->layout->nest('content', 'user.account', array(
				'user' => $user,
			));
		}
	}

	public function post_create() 
	{
		$user = new User;
		$user->email = Input::get('email');
		$user->password = Input::get('password');

		if ($user->save()) {
			Auth::login($user->id);
			return Redirect::to_route('user_account');
		} else {
			return Redirect::to_route('home')
				->with('signup_errors', $user->errors->all())
				->with_input('only', array('email'));
		}
	}

}