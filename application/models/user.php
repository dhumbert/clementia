<?php

class User extends Aware 
{
    const UPGRADED_MSG = 'Your subscription has been upgraded effective immediately.';
    const DOWNGRADED_MSG = 'Your subscription will be downgraded at the end of the current billing period.';

    public static $timestamps = true;

    public static $rules = array(
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'role_id' => 'required',
    );

    public function onSave() 
    {
        // if there's a new password, hash it
        if($this->changed('password')) {
            $this->password = Hash::make($this->password);
        }

        if (isset($this->attributes['password_confirmation'])) {
            unset($this->attributes['password_confirmation']);
        }

        return true;
    }

    public function is_paying_customer()
    {
        return !is_null($this->payment_gateway_id);
    }

    public function create_subscription($subscription, $token)
    {
        $role = Role::find($subscription);
        $customer = IoC::resolve('paymentGateway')->create_customer($this->email, strtolower($role->name), $token);

        $card = $customer->cards->data[0];
        $this->payment_gateway_id = $customer->id;
        $this->card_last_4 = $card->last4;
        $this->card_type = $card->type;
        $this->role_id = $role->id;
        $this->save();
    }

    public function change_subscription($subscription)
    {
        $role = Role::find($subscription);

        if ((int)$role->price == 0) {
            IoC::resolve('paymentGateway')->cancel($this->payment_gateway_id);
            return static::DOWNGRADED_MSG;
        } else if (Role::is_upgrade($this->role, $role)) {
            IoC::resolve('paymentGateway')->upgrade($this->payment_gateway_id, strtolower($role->name));
            $this->role_id = $role->id;
            $this->save();
            $msg = static::UPGRADED_MSG;
        } else {
            $downgrade_date = IoC::resolve('paymentGateway')->downgrade($this->payment_gateway_id, strtolower($role->name));
            $this->downgrade_role_id = $role->id;
            $this->downgrade_date = date('Y-m-d', $downgrade_date);
            $msg = static::DOWNGRADED_MSG;
        }

        $this->save();
        return $msg;
    }

    public function sites()
    {
        return $this->has_many('Site');
    }

    public function role()
    {
        return $this->belongs_to('Role');
    }

    public function allowed_tests()
    {
        return $this->role->tests_per_site;
    }

    public function signup_date()
    {
        return date("Y-m-d", strtotime($this->created_at));
    }

    public function has_reached_his_test_limit($site_id)
    {
        $site = Site::find($site_id);
        $max_tests = $this->allowed_tests();
        $existing_tests = count($site->tests);

        if ($max_tests && $existing_tests >= $max_tests) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function count_sites()
    {
        return count($this->sites);
    }

    public function allowed_sites()
    {
        return $this->role->allowed_sites;
    }

    public function has_reached_site_limit()
    {
        $max_sites = $this->allowed_sites();
        $existing_sites = $this->count_sites();

        // if max sites is null, user can have unlim. sites
        if ($max_sites && $existing_sites >= $max_sites) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function has_sites()
    {
        return count($this->sites) > 0;
    }

    public function sites_dropdown_options()
    {
        $options = array('' => 'Select a site...');
        foreach ($this->sites as $site) {
            $options[$site->id] = $site->get_url('/');
        }

        return $options;
    }

    public function send_password_reset()
    {
        Bundle::start('messages');

        $token = preg_replace('/[^0-9A-Za-z]/', '', Hash::make($this->id));
        $this->token = $token;
        $this->token_generated = date('Y-m-d H:i:s');
        $this->save();

        $message = Message::to($this->email)
        ->from('revdev@gmail.com', 'Clementia')
        ->subject('Password Reset Request')
        ->body(render('email.password_reset', array('token' => $token)))
        ->html(true)
        ->send();
    }

    public function reset_password($new_password)
    {
        $this->password = $new_password;
        $this->token = NULL;
        $this->token_generated = NULL;
        $this->save();
    }
}