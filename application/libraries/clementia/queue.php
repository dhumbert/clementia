<?php

namespace Clementia;

class Queue
{
    public function test_is_queued($id)
    {
        // don't incur the overhead of checking Redis for queued-ness if we're not queuing tests.
        if (\Config::get('tests.run_immediately') === TRUE) return FALSE;

        $is_member = \Redis::db()->sismember(\Config::get('tests.queue.key'), $id);
        return $is_member;
    }

    public function push_test($id)
    {
        \Redis::db()->sadd(\Config::get('tests.queue.key'), $id);
    }

    public function pop_test()
    {
        return \Redis::db()->spop(\Config::get('tests.queue.key'));
    }

    public function there_are_scheduled_tests()
    {
        $count = (int)\Redis::db()->scard(\Config::get('tests.queue.scheduled.key'));
        return $count > 0;
    }

    public function push_scheduled_test($id)
    {
        \Redis::db()->sadd(\Config::get('tests.queue.scheduled.key'), $id);
    }

    public function pop_scheduled_test()
    {
        return \Redis::db()->spop(\Config::get('tests.queue.scheduled.key'));
    }

    public function push_notification(\Test $test)
    {
        $key = \Config::get('tests.queue.notifications.key');
        $existing_notifications = (array)json_decode(\Redis::db()->hget($key, $test->user->id));
        
        array_push($existing_notifications, $test->id);

        \Redis::db()->hset($key, $test->user->id, json_encode($existing_notifications));
    }

    public function pop_notification()
    {
        $key = \Config::get('tests.queue.notifications.key');
        $users = \Redis::db()->hkeys($key);

        $notification = NULL;

        if ($users) {
            $user = array_shift($users);
            if ($user) {
                $tests = (array)json_decode(\Redis::db()->hget($key, $user));
                $notification = new \Clementia\Notification($user, $tests);
                \Redis::db()->hdel($key, $user);
            }
        }
        return $notification;
    }
}