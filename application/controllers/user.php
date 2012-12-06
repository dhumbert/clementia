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

	// update the user
	public function put_index()
	{
		$user = Auth::user();
		$rules = array(
			'email' => 'required|email|unique:users,email,' . $user->id, // force email to be unique, but do not fail on this user's email
		);

		$update_password = FALSE;

		if (Input::get('password') != '') {
			$rules['password'] = 'confirmed';
			$update_password = TRUE;
		}

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails()) {
	    	return Redirect::to_route('user_account')->with('error', $validation->errors->all());
	    } else {
	    	$user->email = Input::get('email');
	    	if ($update_password) $user->password = Input::get('password');

	    	if ($user->save()) {
		    	return Redirect::to_route('user_account')->with('success', 'Account updated');
		    } else {
		    	return Redirect::to_route('user_account')->with('error', $user->errors->all());
		    }
	    }
	}

	public function post_create() 
	{
		$user = new User;
		$user->email = Input::get('email');
		$user->password = Input::get('password');
		$user->role_id = Role::where_name(Config::get('tests.roles.level_0'))->first()->id;

		if ($user->save()) {
			Auth::login($user->id);
			return Redirect::to_route('test_list')->with('success', 'Thanks for signing up!');
		} else {
			return Redirect::to_route('home')
				->with('signup_errors', $user->errors->all())
				->with_input('only', array('email'));
		}
	}

}