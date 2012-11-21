<?php

class ClementiaRequest {
  public function __construct() {
    
  }

  public function get($url) {
    return Requests::get($url);
  }
}