<?php

namespace Clementia;

class Notification
{
    private $user = NULL;
    private $tests = array();

    public function __construct($user_id, array $test_ids)
    {
        $this->user = \User::find($user_id);
        foreach ($test_ids as $id) {
            $this->tests[] = \Test::find($id);
        }
    }

    public function send()
    {
        \Bundle::start('messages');

        $message = \Message::to($this->user->email)
        ->from(\Config::get('messages.from.email'), \Config::get('messages.from.name'))
        ->subject('Test Run Notification')
        ->body(render('email.test_notification', array()))
        ->html(true)
        ->send();
    }
}