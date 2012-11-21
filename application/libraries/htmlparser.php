<?php

class HtmlParser 
{
  private $_doc;

  public function load($html) 
  {
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $this->_doc = $doc;
  }

  public function find_by_tag($tag) 
  {
    $elements = $this->_doc->getElementsByTagName($tag);
    if (count($elements) > 0) {
      return $elements;
    }

    return FALSE;
  }
}