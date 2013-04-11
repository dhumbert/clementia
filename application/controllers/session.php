<?php

class Session_Controller extends Base_Controller 
{

    public $restful = TRUE;

    public function get_create()
    {
        $this->layout->nest('content', 'session.login');
    }

    public function put_create() 
    {
        $credentials = array('username' => Input::get('email'), 'password' => Input::get('password'));

        if (Auth::attempt($credentials)) {
            return Redirect::to_route(Config::get('auth.home_route'));
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