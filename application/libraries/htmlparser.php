<?php

class HtmlParser 
{
  private $_doc;

  public function load($html) 
  {
    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $this->_doc = $doc;
  }

  public function find_by_tag($tag) 
  {
    $elements = $this->_doc->getElementsByTagName($tag);
    if ($elements->length > 0) {
      return $this->domlist_to_array($elements);
    }

    return array();
  }

  public function find_by_id($id) 
  {
    $element = $this->_doc->getElementById($id);
    if ($element) {
      return $element;
    }

    return array();
  }

  public function filter_elements_by_attribute($elements, $attribute, $value = NULL) 
  {
    if (!is_array($elements) || count($elements) == 0) return array();

    $result = array();

    foreach ($elements as $element) {
      $attr = $element->getAttribute($attribute);
      if (!$attr) continue;
      if ($value && $attr !== $value) continue;
      $result[] = $element;
    }

    return $result;
  }

  private function domlist_to_array($domlist)
  {
    $return = array();
    for ($i = 0; $i < $domlist->length; ++$i) {
        $return[] = $domlist->item($i);
    }
    return $return;
  }
}