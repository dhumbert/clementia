<?php

namespace ZafBox;

class Notification
{
    private $user = NULL;
    private $tests = array('failing' => array(), 'passing' => array());

    public function __construct($user_id, array $test_ids)
    {
        $this->user = \User::find($user_id);
        foreach ($test_ids as $id) {
            $test = \Test::find($id);
            if ($test->passing) {
                $this->tests['passing'][] = $test;
            } else {
                $this->tests['failing'][] = $test;
            }
        }
    }

    public function send()
    {
        \Bundle::start('messages');

        $statistics = $this->statistics();

        $message = \Message::to($this->user->email)
        ->from(\Config::get('messages.from.email'), \Config::get('messages.from.name'))
        ->subject('Test Run Notification')
        ->body(render('email.test_notification', array('tests' => $this->tests, 'statistics' => $statistics)))
        ->html(true)
        ->send();
    }

    private function statistics()
    {
        $passing = count($this->tests['passing']);
        $failing = count($this->tests['failing']);

        return array(
            'passing' => $passing,
            'failing' => $failing,
            'pass_rate' => round($passing / ($passing + $failing) * 100, 0),
        );
    }
}