<?php

class User_Controller extends Base_Controller 
{

	public $restful = TRUE;

	public function get_index($id = NULL) 
	{
		if (!$id && Auth::check()) $id = Auth::user()->id;

		$user = User::find($id);
		if (!$user) {
			return Response::error('404');
		} else {
			$this->layout->nest('content', 'user.profile', array(
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
			return Redirect::to_route('user_profile');
		} else {
			return Redirect::to_route('home')
				->with('signup_errors', $user->errors->all())
				->with_input('only', array('email'));
		}
	}

}