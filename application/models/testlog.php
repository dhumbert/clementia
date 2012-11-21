<?php

class TestLog extends Aware 
{
  public static $timestamps = true;

  public static $rules = array(
    'test_id' => 'required',
    'passed' => 'required',
  );

  public function test() 
  {
    return $this->belongs_to('Test');
  }
}