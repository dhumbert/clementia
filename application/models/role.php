<?php

class Role extends Aware 
{
    public static $timestamps = false;

    public static function is_upgrade(Role $current_role, Role $check_role)
    {
        return $current_role->price < $check_role->price;
    }

    public function users()
    {
        return $this->has_many('User');
    }

    public function __toString()
    {
        return $this->name;
    }

    public function create_subscription_in_payment_gateway()
    {
        Stripe::setApiKey(Config::get('stripe.secret_key'));
        Stripe_Plan::create(array(
                "amount" => $this->price * 100, // in cents
                "interval" => "month",
                "name" => $this->name,
                "currency" => "usd",
                "id" => strtolower($this->name),
            )
        );
    }
}