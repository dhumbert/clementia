<?php

class HtmlParser {
  private $_doc;

  public function load($html) {
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $this->_doc = $doc;
  }

  public function find($element, $innertext = NULL) {
    $elements = $this->_doc->getElementsByTagName($element);
    if (count($elements) > 0) {
      return $elements;
    }

    return FALSE;
  }
}