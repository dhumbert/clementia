<?php

namespace ZafBox;

class Tester
{
    const TYPE_TEXT = 'text';
    const TYPE_ELEMENT = 'element';
    const TYPE_RESPONDS = 'responds';

    public function get_types()
    {
        return array(
            self::TYPE_RESPONDS => 'Test that the page is up and responsive',
            self::TYPE_TEXT => 'Test for the presence of a text string',
            self::TYPE_ELEMENT => 'Test for the existence of HTML elements',
        );
    }
}