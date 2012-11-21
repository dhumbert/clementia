<?php

class Tester
{
  private $_requests = NULL;

  public function __construct()
  {
    $this->_requests = IoC::resolve('requests');
    $this->_parser = IoC::resolve('htmlparser');
  }

  public function test($type, $url, $options = array()) {
    if (method_exists($this, 'test_' . $type)) {
      return call_user_func_array(array(&$this, 'test_'.$type), array($url, $options));
    }
  }

  public function test_element($url, $options)
  {
    $element = $options['element'];
    $text = isset($options['text']) ? $options['text'] : NULL;

    $result = $this->_requests->get($url);

    if ($result->status_code == 200) {
      $body = $result->body;

      $this->_parser->load($body);

      $elements = $this->_parser->find($element);

      if ($elements->length > 0) {
        if ($text) { // test for matching innertext
          foreach ($elements as $element) {
            return $element->textContent === $text;
          }
        } else {
          return TRUE; // we just needed to check for the existence of the element
        }
      }
    }

    return FALSE;
  }
}