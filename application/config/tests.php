<?php

return array(
    'types' => array(
        'text' => 'Test for the presence of a text string',
        'element' => 'Test for the existence of HTML elements',
    ),
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
        'tracking_set_key' => 'test_queue_tracker',
    ),
    'roles' => array(
        'level_0' => 'Free',
    ),
); 