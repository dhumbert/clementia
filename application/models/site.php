<?php

class Site extends Aware
{
    public static $timestamps = TRUE;

    /**
     * Simple validation rules for the model.
     * @var array
     */
    public static $rules = array(
        'domain' => 'required|url',
    );

    /**
     * Relationships.
     */
    public function user()
    {
        return $this->belongs_to('User');
    }

    public function tests()
    {
        return $this->has_many('Test');
    }
}