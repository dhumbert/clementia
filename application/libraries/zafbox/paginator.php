<?php

namespace ZafBox;
use Laravel\HTML;
use Laravel\URI;
use Laravel\Request;

class Paginator extends \Laravel\Paginator
{
    /**
     * Override parent links method to add CSS classes
     */
    public function links($adjacent = 3)
    {
        if ($this->last <= 1) return '';

        // The hard-coded seven is to account for all of the constant elements in a
        // sliding range, such as the current page, the two ellipses, and the two
        // beginning and ending pages.
        //
        // If there are not enough pages to make the creation of a slider possible
        // based on the adjacent pages, we will simply display all of the pages.
        // Otherwise, we will create a "truncating" sliding window.
        if ($this->last < 7 + ($adjacent * 2))
        {
            $links = $this->range(1, $this->last);
        }
        else
        {
            $links = $this->slider($adjacent);
        }

        $content = '<ul>' . $this->previous() . $links . $this->next() . '</ul>';

        return '<div class="pagination pagination-large">'.$content.'</div>';
    }

    /**
     * Override parent link method to do away with query params and use hash
     */
    protected function link($page, $text, $class)
    {
        // ok, sort of cheating but change the "appendage" to "prependage"
        $hash = '#' . $this->appendage($this->appends) . "/" . $page;

        return '<li'.HTML::attributes(array('class' => $class)).'>'. HTML::link($hash, $text, array(), Request::secure()).'</li>';
    }

    /**
     * Override parent appendage method to change GET params into hash params
     */
    protected function appendage($appends)
    {
        // The developer may assign an array of values that will be converted to a
        // query string and attached to every pagination link. This allows simple
        // implementation of sorting or other things the developer may need.
        if ( ! is_null($this->appendage)) return $this->appendage;

        if (count($appends) <= 0)
        {
            return $this->appendage = '';
        }

        foreach ($appends as $key => $value) {
            // if the appends array is associative, add the key before the value
            if (!is_numeric($key)) {
                $this->appendage .= "/" . $key;
            }
            $this->appendage .= "/" . $value;
        }

        return $this->appendage;
    }
}