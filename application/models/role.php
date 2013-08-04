<?php

class Role extends Aware 
{
    public static $timestamps = false;

    public function users()
    {
        return $this->has_many('User');
    }

    public function __toString()
    {
        return $this->name;
    }
}