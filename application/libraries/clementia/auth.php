<?php

namespace Clementia;

class Auth extends \Laravel\Auth\Drivers\Eloquent
{
    /* extend the check method to optionally check for a role */
    public function check($role = NULL)
    {
        $logged_in = parent::check();
        
        if ($role) {
            $logged_in = FALSE;
            if ($this->user()->role_id == \Role::where_name($role)->first()->id) {
                $logged_in = TRUE;
            }
        }

        return $logged_in;
    }
}