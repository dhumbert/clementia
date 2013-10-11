<?php

class Downgrade extends Aware
{
    public static $timestamps = TRUE;

    /**
     * Relationships.
     */
    public function user()
    {
        return $this->belongs_to('User');
    }

    public function role()
    {
        return $this->belongs_to('Role');
    }
}