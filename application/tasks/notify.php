<?php

class Notify_Task 
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        for ($i = 0; $i < Config::get('tests.queue.notifications.limit'); $i++) {
            $notification = IoC::resolve('queue')->pop_notification();
            if ($notification) {
                $notification->send();
            }
        }
    }    
}