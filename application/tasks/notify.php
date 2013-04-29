<?php

class Notify_Task 
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        // wait until all scheduled tests are run, to avoid notifying
        // users multiple times
        if (!IoC::resolve('queue')->there_are_scheduled_tests()) {
            for ($i = 0; $i < Config::get('tests.queue.notifications.limit'); $i++) {
                $notification = IoC::resolve('queue')->pop_notification();
                if ($notification) {
                    $notification->send();
                }
            }
        }
    }    
}