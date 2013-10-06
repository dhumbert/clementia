<?php

namespace Clementia;

class PaymentGateway
{
    public function create_customer($email, $subscription, $token)
    {
        \Stripe::setApiKey(\Config::get('stripe.secret_key'));
        $customer = \Stripe_Customer::create(array(
            'email' => $email,
            'plan' => $subscription,
            'card' => $token,
        ));

        return $customer;
    }
}