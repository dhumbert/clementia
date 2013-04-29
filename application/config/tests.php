<?php

return array(
    'per_page' => 9,
    'tags' => array(
        '' => 'Any',
        'div' => 'div',
        'h1' => 'h1',
        'h2' => 'h2',
        'h3' => 'h3',
        'h4' => 'h4',
        'h5' => 'h5',
        'h6' => 'h6',
    ),
    'allowed_attributes' => array(
        'class',
    ),
    'run_immediately' => TRUE,
    'queue' => array(
        'key' => 'test_queue',
        'limit' => 10,
        'scheduled' => array(
            'key' => 'daily_test_queue',
            'limit' => 10,
        ),
        'notifications' => array(
            'key' => 'notification_queue',
            'limit' => 10,
        ),
    ),
    'roles' => array(
        'level_0' => 'Free',
    ),
); 