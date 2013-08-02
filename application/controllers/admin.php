<?php

class Admin_Controller extends Base_Controller
{

    public $restful = TRUE;

    public function get_index()
    {
        $users = User::all();
        $this->layout->nest('content', 'admin.home', array(
            'users' => $users,
        ));
    }
}