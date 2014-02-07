<?php

class ScheduleTests_Task 
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        $tests = Test::get_scheduled_tests();
        foreach ($tests as $test) {
            IoC::resolve('queue')->push_scheduled_test($test);
            print date("Y-m-d H:i:s") . " | Scheduling test " . $test->id . "\n";
        }
    }    
}