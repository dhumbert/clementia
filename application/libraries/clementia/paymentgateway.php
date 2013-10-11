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

    public function upgrade($payment_gateway_id, $subscription)
    {
        \Stripe::setApiKey(\Config::get('stripe.secret_key'));
        $c = \Stripe_Customer::retrieve($payment_gateway_id);
        $c->updateSubscription(array("plan" => $subscription, "prorate" => true));

        // invoice right away to charge right now
        \Stripe_Invoice::create(array(
            "customer" => $payment_gateway_id
        ))->pay();
    }

    public function downgrade($payment_gateway_id, $subscription)
    {
        \Stripe::setApiKey(\Config::get('stripe.secret_key'));
        $c = \Stripe_Customer::retrieve($payment_gateway_id);
        $subscription = $c->updateSubscription(array("plan" => $subscription, "prorate" => false));
        return $subscription->current_period_end;
    }
}