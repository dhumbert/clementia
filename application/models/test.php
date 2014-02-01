<?php

class Test extends Aware 
{
    public static $timestamps = TRUE;
    public $skip_limit_check = FALSE;
    const TEST_QUEUED = 1;
    const TEST_RUN = 2;

    /**
     * Simple validation rules for the model.
     * @var array
     */
    public static $rules = array(
        'description' => 'required',
        'type' => 'required',
        'site_id' => 'required',
    );

    /**
     * Get tests for a user.
     * @param User $user The user
     * @param string $site The site to load tests for
     * @param string $status Filter by status: passing|failing|never-run
     * @param string $sort Column to sort by
     * @param string $dir Sort direction: asc|desc
     * @return array An array of Test objects
     */
    public static function tests_for_user($user, $site = NULL, $status = NULL, $sort = NULL, $dir = NULL)
    {
        $tests = NULL;
        $sort = $sort ?: 'last_run';
        $dir = $dir ?: 'desc';

        $tests = DB::table('tests')
            ->join('sites', 'tests.site_id', '=', 'sites.id')
            ->where('sites.user_id', '=', $user->id);

        if ($site !== 'all' && $site !== NULL) {
            $tests->where('sites.domain', '=', $site);
        }

        if ($status == 'passing') {
            $tests->where('tests.passing', '=', TRUE);
        } elseif ($status == 'failing') {
            $tests->where('tests.passing', '=', FALSE)->where_not_null('tests.last_run');
        } elseif ($status == 'never-run') {
            $tests->where_null('last_run');
        }

        $limit = Config::get('tests.per_page', 9); #todo user preference
        return $tests->order_by($sort, $dir)->paginate($limit, array('tests.id'));
    }

    /**
     * Get tests for user and add some information for the AJAX test list view.
     */
    public static function tests_for_ajax($user, $site, $status = NULL, $sort = NULL, $dir = NULL)
    {
        $tests = Test::tests_for_user($user, $site, $status, $sort, $dir);
        $final_tests = array();
        $response = new stdClass;

        $i = 1;
        foreach ($tests->results as $test) {
            $test = Test::find($test->id);
            $test->status = $test->status();

            $last_run = $test->last_run_info();
            $test->lastruntext = $last_run['text'];
            $test->lastruntime = $last_run['time'];
            $test->site_domain = $test->site->domain;

            $test->link = URL::to_route('test_detail', array($test->id));

            $test->new_row = $i % 3 === 0 || $i === count($tests->results);
            $i++;

            $final_tests[] = $test->to_array();
        }

        $response->tests = $final_tests;
        $response->pagination = $tests->appends(array($site, $status))->links();

        return $response;
    }

    /**
     * Get all tests that are set to run automatically.
     * @return array Array of Test models
     */
    public static function get_scheduled_tests()
    {
        return Test::where('autorun', '=', TRUE)->get();
    }

    /**
     * Set test options.
     * @param array $options Associative array of options
     */
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

    /**
     * Get an array of test options.
     * @return array The test options
     */
    public function get_options() 
    {
        return json_decode($this->get_attribute('options'), TRUE);
    }

    /**
     * Check whether a given test option is set.
     * @param string $key The name of the option
     * @return boolean
     */
    public function option($key)
    {
        if (!$this->options) $this->options = array();

        return array_key_exists($key, $this->options) ? $this->options[$key] : NULL;
    }

    /**
     * Get the current status of the test.
     * @return string passing|failing|never-run
     */
    public function status()
    {
        if ($this->passing) {
            return 'passing';
        } else if ($this->last_run) {
            return 'failing';
        } else {
            return 'never-run';
        }
    }

    /**
     * Get last run info for the tests
     * @return array An array with indices time, class, text
     */
    public function last_run_info()
    {
        $info = array(
            'text' => 'Never Run',
            'time' => '',
        );

        if ($this->last_run) {
            $info['time'] = DateFmt::Format('AGO[t]IF-FAR[M__ d##, y##]', strtotime($this->last_run)); 
            $info['text'] = $this->passing ? 'Passed' : 'Failed';
        }

        return $info;
    }

    public function full_url()
    {
        return $this->site->get_url($this->url);
    }

    /**
    * Get some nice descriptive text about the test.
    * @return array An array with keys description and details
    */
    public function generate_description_for_output() 
    {
        $description = 'Unknown Test';
        $details = array();

        switch ($this->type) {
            case ZafBox\Tester::TYPE_ELEMENT:
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
            case ZafBox\Tester::TYPE_TEXT:
                $description = sprintf('Test for presence of text <code>%s</code>', $this->option('text'));
                if ($this->option('case_sensitive') != '' && (bool)$this->option('case_sensitive') == TRUE) {
                    $details[] = 'Case sensitive';
                } else {
                    $details[] = 'Case insensitive';
                }
                break;
            case ZafBox\Tester::TYPE_RESPONDS:
                $description = 'Test that the page is active and responds to requests';
                break;
        }

        return array('description' => $description, 'details' => $details);
    }

    /**
    * Either run or queue the test, depending on config.
    * @return const Whether the test was run or queued
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
    * @return void
    */
    public function run() 
    {
        $tester = IoC::resolve('tester');
        try {
            $passed = $tester->test($this->type, $this->full_url(), $this->options);
        } catch (Exception $e) {
            $passed = false;
        }

        $message = $passed ? 'Test Passed' : 'Test Failed'; #todo: more descriptive messages

        $this->passing = (int)((bool)$passed);
        $this->last_run = date('Y-m-d H:i:s');
        $this->save();

        $screenshot = $this->screenshot();

        Test\Log::create(array(
            'test_id' => $this->id,
            'message' => $message,
            'passed' => $passed,
            'screenshot' => $screenshot,
        ));
    }

    public function screenshot()
    {
        $screenshot = IoC::resolve('screenshot', array($this->full_url()));
        try {
            $filename = $screenshot->capture();
            return $filename;
        } catch (Exception $e) {
            // todo: something useful?
        }
    }

    public function notify()
    {
        IoC::resolve('queue')->push_notification($this);
    }

    /**
    * Queue the test to be run.
    * @return void
    */
    public function queue() 
    {
        IoC::resolve('queue')->push_test($this);
    }

    /**
     * Check whether a test is queueud
     * @return boolean
     */
    public function is_queued()
    {
        return IoC::resolve('queue')->test_is_queued($this->id);
    }

    /**
    * Destroy the record if the user is able to.
    * @param integer $user_id The ID of the user
    * @return boolean
    */
    public function destroy_if_user_can($user_id) 
    {
        if ($user_id === $this->site->user->id) {
            $this->delete();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Hook into onSave event and do a couple of more complex validations.
     * @throws Invalid_Options_Exception if options are not valid
     * @throws Max_Tests_Exceeded_Exception if user has exceed max tests
     * @return boolean
     */
    public function onSave() 
    {
        // verify that the appropriate options are set for each test type
        switch ($this->type) {
            case ZafBox\Tester::TYPE_TEXT:
                if (!array_key_exists('text', $this->options) || trim($this->options['text']) === '') {
                    throw new Invalid_Options_Exception("You must set the text to be searched for");
                }
                break;
            case ZafBox\Tester::TYPE_ELEMENT:
                if (
                    (!array_key_exists('tag', $this->options) || trim($this->options['tag']) === '')
                    && (!array_key_exists('id', $this->options) || trim($this->options['id']) === '')
                ) {
                    throw new Invalid_Options_Exception("You must select either a tag or ID to search for");
                }
                break;
        }

        if (!$this->skip_limit_check && !$this->exists && Auth::user()->has_reached_his_test_limit($this->site_id)) {
            throw new Max_Tests_Exceeded_Exception;
        }

        return TRUE;
    }

    /**
    * Relationships.
    */
    public function site()
    {
        return $this->belongs_to('Site');
    }

    public function logs()
    {
        return $this->has_many('Test\Log');
    }
}

class Max_Tests_Exceeded_Exception extends Exception {}
class Invalid_Options_Exception extends Exception {}