<?php

class Test extends Aware 
{
  public static $timestamps = true;

  public static $rules = array(
    'url' => 'required|url',
    'type' => 'required',
  );

  public function set_options($options) 
  {
    $options = array_map_deep('trim', $options);
    
    // traverse options and remove any blank ones
    foreach ($options as $key => $val) {
      if (empty($val)) {
        unset($options[$key]);
      } else {
        if (is_array($val)) {
          foreach ($val as $val_key => $val_val) {
            if (empty($val_val)) {
              unset($options[$key]);
            }
          }
        }
      }
    }

    $this->set_attribute('options', json_encode($options));
  }

  public function get_options() 
  {
    return json_decode($this->get_attribute('options'), TRUE);
  }

  public function option($key)
  {
    return array_key_exists($key, $this->options) ? $this->options[$key] : NULL;
  }

  /**
   * Get some nice descriptive text about the test.
   */
  public function generate_description_for_output() 
  {
    $description = 'Unknown Test';
    $details = array();

    switch ($this->type) {
      case 'element':
        $description = sprintf('Test for presence of tag <code>%s</code>', $this->option('tag'));
        if ($this->option('id') != '') {
          $details[] = sprintf('With ID <code>%s</code>', $this->option('id'));
        }

        if ($this->option('attributes') != '') {
          foreach ($this->option('attributes') as $attr => $val) {
            $details[] = sprintf('With attribute <code>%s</code> equal to <code>%s</code>', $attr, $val);
          }
        }

        if ($this->option('inner_text') != '') {
          $details[] = sprintf('With text <code>%s</code>', $this->option('inner_text'));
        }
        break;
      case 'text':
        $description = sprintf('Test for presence of text <code>%s</code>', $this->option('text'));
        if ($this->option('case_sensitive') != '' && (bool)$this->option('case_sensitive') == TRUE) {
          $details[] = 'Case sensitive';
        } else {
          $details[] = 'Case insensitive';
        }
        break;
    }

    return array('description' => $description, 'details' => $details);
  }

  /**
   * Run the test and create a TestLog.
   */
  public function run() 
  {
    $tester = IoC::resolve('tester');
    $passed = $tester->test($this->type, $this->url, $this->options);

    $message = $passed ? 'Test Passed' : 'Test Failed'; #todo: more descriptive messages

    Test\Log::create(array(
      'test_id' => $this->id,
      'message' => $message,
      'passed' => $passed,
    ));
  }

  /**
   * Destroy the record if the user is able to.
   */
  public function destroy_if_user_can($user_id) 
  {
    if ($user_id === $this->user_id) {
      $this->delete();
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function onSave() 
  {
    return $this->check_for_max_tests();
  }

  private function check_for_max_tests() 
  {
    if (Auth::user()->has_reached_his_test_limit()) {
      throw new Max_Tests_Exceeded_Exception;
    } else {
      return TRUE;
    }
  }

  /**
   * Relationships.
   */
  public function user() 
  {
    return $this->belongs_to('User');
  }

  public function logs()
  {
    return $this->has_many('Test\Log');
  }
}

class Max_Tests_Exceeded_Exception extends Exception {}