<?php

namespace Clementia;

class Tester
{
    const TYPE_TEXT = 'text';
    const TYPE_ELEMENT = 'element';

    private $_requests = NULL;

    public function __construct()
    {
        $this->_requests = \IoC::resolve('requests');
        $this->_parser = \IoC::resolve('htmlparser');
    }

    public function get_types()
    {
        return array(
            self::TYPE_TEXT => 'Test for the presence of a text string',
            self::TYPE_ELEMENT => 'Test for the existence of HTML elements',
        );
    }

    public function test($type, $url, $options = array()) 
    {
        if (method_exists($this, 'test_' . $type)) {
            return call_user_func_array(array(&$this, 'test_'.$type), array($url, $options));
        } else {
            return FALSE;
        }
    }

    public function test_element($url, $options)
    {
        $loaded = $this->get_url($url);
        if (!$loaded) return FALSE;

        $elements = array();

        // load elements by tag name, if supplied
        if (isset($options['tag']) && $options['tag'] != '') {
            $elements = $this->_parser->find_by_tag($options['tag']);
            if (count($elements) == 0) return FALSE;
        }

        // Find the elements that have the supplied ID
        // if elements were found above, it uses those elements
        if (isset($options['id']) && $options['id'] != '') {
            if (count($elements) == 0) { // no elements found by tag
                $element = $this->_parser->find_by_id($options['id']);
                if (!$element) {
                    return FALSE;
                } else {
                    $elements = array($element);
                }
            } else { // we found elements by tag, now see if we have one with the right ID
                $elements = $this->_parser->filter_elements_by_attribute($elements, 'id', $options['id']);
            }
        }

        // by this point, if we don't have any elements, FAIL
        if (count($elements) == 0) return FALSE;

        // Find the elements that have the supplied class
        // we must have found elements by tag or ID
        if (isset($options['attributes']) && is_array($options['attributes']) 
            && count($options['attributes']) > 0) {

            foreach ($options['attributes'] as $attribute => $value) {
                if (count($elements) == 0) break; // OK, we've filtered out everything
                $elements = $this->_parser->filter_elements_by_attribute($elements, $attribute, $value);
            }
        }

        // Find the elements that have the supplied innertext
        // we must have found elements by tag or ID
        if (isset($options['inner_text']) && $options['inner_text'] != '') {
            foreach ($elements as $i => $element) {
                if ($element->textContent !== $options['inner_text']) {
                    unset($elements[$i]);
                }
            }
        }

        return count($elements) > 0;
    }

    public function test_text($url, $options)
    {
        if (!isset($options['text'])) return FALSE;
        $case_sensitive = isset($options['case_sensitive']) ? (bool)$options['case_sensitive'] : FALSE;

        $result = $this->_requests->get($url);
        if ($result->status_code == 200) {
            $func = $case_sensitive ? 'strstr' : 'stristr';
            if ($func($result->body, $options['text'])) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    private function get_url($url) 
    {
        $result = $this->_requests->get($url);

        if ($result->status_code == 200) {
            $this->_parser->load($result->body);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}