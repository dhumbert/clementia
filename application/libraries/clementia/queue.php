<?php

namespace Clementia;

class Queue
{
    public function add_test($id)
    {
        \Redis::db()->sadd(\Config::get('tests.queue.key'), $id);
    }

    public function test_is_queued($id)
    {
        // don't incur the overhead of checking Redis for queued-ness if we're not queuing tests.
        if (\Config::get('tests.run_immediately') === TRUE) return FALSE;

        $is_member = \Redis::db()->sismember(\Config::get('tests.queue.key'), $id);
        return $is_member;
    }

    public function pop_test()
    {
        return \Redis::db()->spop(\Config::get('tests.queue.key'));
    }
}