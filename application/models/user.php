<?php

class User extends Aware 
{
  public static $timestamps = true;

  public static $rules = array(
    'email' => 'required|email|unique:users',
    'password' => 'required',
    'role_id' => 'required',
  );

  public function onSave() 
  {
    // if there's a new password, hash it
    if($this->changed('password')) {
      $this->password = Hash::make($this->password);
    }

    return true;
  }

  public function tests()
  {
    return $this->has_many('Test');
  }

  public function role()
  {
    return $this->belongs_to('Role');
  }

  public function has_reached_his_test_limit() {
    $max_tests = $this->role->allowed_tests;
    $existing_tests = count($this->tests);

    if ($max_tests && $existing_tests >= $max_tests) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}