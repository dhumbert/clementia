<?php

class RunScheduledTests_Task 
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        for ($i = 0; $i < Config::get('tests.queue.scheduled.limit'); $i++) {
            $test_id = IoC::resolve('queue')->pop_scheduled_test();
            if ($test_id) {
                $test = Test::find($test_id);
                $test->run();
                $test->notify();
            }
        }
    }    
}