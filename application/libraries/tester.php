<?php

class Tester {
  private $_requests = NULL;

  public function __construct() {
    $this->_requests = IoC::resolve('requests');
    $this->_parser = IoC::resolve('htmlparser');
  }

  public function element($url, $element, $text = NULL) {
    $result = $this->_requests->get($url);
    if ($result->status_code == 200) {
      $body = $result->body; echo $body."\r\n";
      $this->_parser->load($body);
      $elements = $this->_parser->find($element);

      if ($elements->length > 0) {
        if ($text) { // test for matching innertext
          foreach ($elements as $element) {
            return $element->textContent === $text;
          }
        } else {
          return TRUE;
        }
      }
    }

    return FALSE;
  }
}