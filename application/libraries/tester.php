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
    $failed = FALSE;

    $loaded = $this->get_url($url);
    if (!$loaded) return FALSE;

    $elements = array();

    // load elements by tag name, if supplied
    if (isset($options['tag'])) {
      $elements = $this->_parser->find_by_tag($options['tag']);
      if (!$elements) return FALSE;
    } 

    // Find the elements that have the supplied ID
    // if elements were found above, it uses those elements
    if (isset($options['id'])) {
      if (!$elements) { // no elements found by tag
        $element = $this->_parser->find_by_id($options['id']);
        if (!$element) {
          return FALSE;
        } else {
          $elements = array($element);
        }
      } else { // we found elements by tag, now see if we have one with the right ID
        $success = FALSE;
        foreach ($elements as $element) {
          $id = $element->getAttribute('id');
          $success = $id == $options['id'];
        }
        $failed = !$success;
      }
    }

    // Find the elements that have the supplied class
    // we must have found elements by tag or ID
    if (isset($options['class'])) {

    }

    // Find the elements that have the supplied innertext
    // we must have found elements by tag or ID
    if (isset($options['text'])) {
      $success = FALSE;
      if (!$elements) return FALSE;
      foreach ($elements as $element) {
        $success = $element->textContent === $options['text'];
      }
      $failed = !$success;
    }

    return !$failed;
  }

  private function get_url($url) {
    $result = $this->_requests->get($url);

    if ($result->status_code == 200) {
      $this->_parser->load($result->body);
      return TRUE;
    } else {
      return FALSE;
    }
  }
}