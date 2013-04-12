<?php

class Test extends Aware 
{
    public static $timestamps = true;
    const TEST_QUEUED = 1;
    const TEST_RUN = 2;

    public static $rules = array(
        'description' => 'required',
        'url' => 'required|url',
        'type' => 'required',
    );

    public static function tests_for_user($user, $status = NULL, $sort = NULL, $dir = NULL)
    {
        $tests = NULL;
        $sort = $sort ?: 'description';
        $dir = $dir ?: 'asc';

        if (!$status || $status == 'all') {
        // all tests
            $tests = $user->tests();
        } elseif ($status == 'passing') {
            $tests = $user->tests()->where('passing', '=', TRUE);
        } elseif ($status == 'failing') {
            $tests = $user->tests()->where('passing', '=', FALSE)->where_not_null('last_run');
        } elseif ($status == 'never-run') {
            $tests = $user->tests()->where_null('last_run');
        }

        return $tests->order_by($sort, $dir)->get();
    }

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
        if (!$this->options) $this->options = array();

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
            case Clementia\Tester::TYPE_ELEMENT:
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
            case Clementia\Tester::TYPE_TEXT:
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
    * Either run or queue the test, depending on config.
    */
    public function begin()
    {
        if (Config::get('tests.run_immediately') === TRUE) {
            $this->run();
            return self::TEST_RUN;
        } else {
            $this->queue();
            return self::TEST_QUEUED;
        }
    }

    /**
    * Run the test and create a TestLog.
    */
    public function run() 
    {
        $tester = IoC::resolve('tester');
        $passed = $tester->test($this->type, $this->url, $this->options);

        $message = $passed ? 'Test Passed' : 'Test Failed'; #todo: more descriptive messages

        $this->passing = (int)((bool)$passed);
        $this->last_run = date('Y-m-d H:i:s');
        $this->save();

        Test\Log::create(array(
            'test_id' => $this->id,
            'message' => $message,
            'passed' => $passed,
        ));
    }

    /**
    * Queue the test to be run.
    */
    public function queue() 
    {
        IoC::resolve('queue')->add_test($this->id);
    }

    public function is_queued()
    {
        return IoC::resolve('queue')->test_is_queued($this->id);
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
        // verify that the appropriate options are set for each test type
        switch ($this->type) {
            case Clementia\Tester::TYPE_TEXT:
                if (!array_key_exists('text', $this->options) || trim($this->options['text']) === '') {
                    throw new Invalid_Options_Exception("You must set the text to be searched for");
                }
                break;
            case Clementia\Tester::TYPE_ELEMENT:
                if (
                    (!array_key_exists('tag', $this->options) || trim($this->options['tag']) === '')
                    && (!array_key_exists('id', $this->options) || trim($this->options['id']) === '')
                ) {
                    throw new Invalid_Options_Exception("You must select either a tag or ID to search for");
                }
                break;
        }

        $this->check_for_max_tests();

        return TRUE;
    }

    private function check_for_max_tests() 
    {
        if (!$this->exists && Auth::user()->has_reached_his_test_limit()) {
            throw new Max_Tests_Exceeded_Exception;
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
class Invalid_Options_Exception extends Exception {}