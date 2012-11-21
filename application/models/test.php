<?php

class Test extends Aware {
  public static $timestamps = true;

  public static $rules = array(
    'url' => 'required|url',
    'type' => 'required',
  );

  public function save_options($options) {
    switch($this->type) {
      case 'element':
        $this->options = json_encode(array(
          'element' => $options['element'],
          'text' => $options['text'],
        ));
        break;
    }
  }

  public function user() {
    return $this->belongs_to('User');
  }
}