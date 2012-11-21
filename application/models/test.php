<?php

class Test extends Aware 
{
  public static $timestamps = true;

  public static $rules = array(
    'url' => 'required|url',
    'type' => 'required',
  );

  public function save_options($options) 
  {
    switch($this->type) {
      case 'element':
        $this->options = json_encode(array(
          'element' => $options['element'],
          'text' => $options['text'],
        ));
        break;
    }
  }

  public function user() 
  {
    return $this->belongs_to('User');
  }

  public function logs()
  {
    return $this->has_many('TestLog');
  }

  public function run() {
    $tester = IoC::resolve('tester');
    $passed = $tester->test($this->type, $this->url, (array)json_decode($this->options));

    $message = $passed ? 'Test Passed' : 'Test Failed'; #todo: more descriptive messages

    TestLog::create(array(
      'test_id' => $this->id,
      'message' => $message,
      'passed' => $passed,
    ));
  }
}