<?php

class Role extends Aware 
{
  public function users()
  {
    return $this->has_many('User');
  }
}