<?php

namespace Clementia;

class Request {
    public function __construct() {

    }

    public function get($url) {
        return \Requests::get($url);
    }
}