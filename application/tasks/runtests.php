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
            $test = IoC::resolve('queue')->pop_test();
            if ($test) {
                $test = Test::find($test);
                $test->run();
                IoC::resolve('queue')->test_complete($test->id);
            }
        }
    }    
}