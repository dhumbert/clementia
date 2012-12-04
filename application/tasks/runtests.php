<?php

class RunTests_Task 
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        for ($i = 0; $i < Config::get('tests.queue.limit'); $i++) {
            $test = Redis::db()->lpop(Config::get('tests.queue.key'));
            if ($test) {
                $test = Test::find($test);
                $test->run();
                Redis::db()->srem(Config::get('tests.queue.tracking_set_key'), $test->id);
            }
        }
    }    
}