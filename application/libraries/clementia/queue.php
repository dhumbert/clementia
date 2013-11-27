<?php

namespace Clementia;

class Queue
{
    public function test_is_queued($id)
    {
        // don't incur the overhead of checking Redis for queued-ness if we're not queuing tests.
        if (\Config::get('tests.run_immediately') === TRUE) return FALSE;

        $is_member = \Redis::db()->sismember('tests_in_queue', $id);
        return $is_member;
    }

    public function push_test(\Test $test)
    {
        // i was originally using a set, which would not require this check.
        // however, i wanted to use brpop in pythropod so i have converted the set to a list
        if ($this->test_is_queued($test->id))
            return;

        $fields = array(
            'id' => $test->id,
            'url' => $test->full_url(),
            'type' => $test->type,
        );

        $fields['text'] = $test->option('text');

        \Redis::db()->sadd('tests_in_queue', $test->id);

        \Redis::db()->lpush(\Config::get('tests.queue.key'), json_encode($fields));
    }

    public function get_test_results()
    {
        $results = array();
        $result = \Redis::db()->lpop('test_results');
        while ($result) {
            $results[] = json_decode($result);
            $result = \Redis::db()->lpop('test_results');
        }
        return $results;
    }

    public function remove_queued_test($id)
    {
        \Redis::db()->srem('tests_in_queue', $id);
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