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

    public function get_signup()
    {
        $this->layout->nest('content', 'user.signup', array(

        ));
    }

    public function post_signup()
    {
        $user = new User;
        $user->email = Input::get('email');
        $user->password = Input::get('password');
        $user->password_confirmation = Input::get('password_confirmation');
        $user->role_id = Role::where_name(Config::get('tests.roles.level_0'))->first()->id;

        if ($user->save()) {
            Auth::login($user->id);
            return Redirect::to_route(Config::get('auth.home_route'))->with('success', 'Thanks for signing up!');
        } else {
            return Redirect::to_route('signup')
                ->with('signup_errors', $user->errors->all())
                ->with_input('only', array('email'));
        }
    }

    public function get_forgot_password()
    {
        $this->layout->nest('content', 'user.forgot_password');
    }

    public function post_forgot_password()
    {
        $user = User::where_email(Input::get('email'))->first();
        if ($user) {
            $user->send_password_reset();
            return Redirect::to_route('user_forgot_password')->with('success', 'Alright! Check your email for a password reset link.');
        } else {
            return Redirect::to_route('user_forgot_password')->with('error', 'Email address not found');
        }
    }

    public function get_reset_password($token)
    {
        $user = User::where_token($token)->first();
        if ($user) $expired = strtotime($user->token_generated) < strtotime("now - " . Config::get('auth.reset_token_expires_in_hours') . " hours");
        
        if ($user && !$expired) {
            $this->layout->nest('content', 'user.forgot_password_reset');
        } else {
            return Redirect::to_route('user_forgot_password')->with('error', 'Invalid or expired password reset request. Please start a new reset password request.');
        }
    }

    public function post_reset_password($token)
    {
        $user = User::where_token($token)->first();

        if (!$user) {
            return Response::error('404');
        } else {
            $rules = array(
                'password' => 'required|confirmed',
            );

            $validation = Validator::make(Input::all(), $rules);

            if ($validation->fails()) {
                return Redirect::to_route('user_forgot_password_reset', array($token))
                ->with('error', $validation->errors->all());
            } else {
                $user->reset_password(Input::get('password'));

                return Redirect::to_route('home')->with('success', 'Your password has been reset. Log in below.');
            }
        }
    }

    public function delete_delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response::error(404);
        }

        $user->delete();

        return Redirect::to('admin')->with('success', 'User deleted');
    }

    public function get_subscription()
    {
        $user = Auth::user();
        if (!$user) {
            return Response::error('404');
        } else {
            $this->layout->nest('content', 'user.subscription', array(
                'user' => $user,
                'roles' => Role::order_by('price', 'asc')->where('name', '!=', 'Administrator')->get(),
                'stripe_key' => Config::get('stripe.publishable_key'),
            ));
        }
    }

    public function post_subscription()
    {
        $paymentToken = Input::get('stripeToken');
        $subscription = Input::get('subscription');

        $user = Auth::user();

        if (!$paymentToken || !$user || !$subscription) {
            return Response::error('500');
        }

        $user->create_payment_gateway_customer($subscription, $paymentToken);

        return Redirect::to('account')->with('success', 'Your subscription has been changed effective immediately. <strong>Thanks!</strong>');
    }

}