<?php

class GenerateFakeTests_Task 
{
    private $sample_tests = array(
        'valid' => array(
            Clementia\Tester::TYPE_TEXT => array(
                'freelance',
                'marketing, and web development firms',
                'I have experience with PHP',
                'comfortable',
                'questions about the services',
                'Coding is my passion',
            ),
            Clementia\Tester::TYPE_ELEMENT => array(
                'content-header',
                'lightboxOverlay',
                'footer',
            ),
        ),
        'invalid' => array(
            Clementia\Tester::TYPE_TEXT => array(
                'asdf',
                'lorem',
                'warrgarble',
                'ich bin ein berliner',
                'dolorsitamet',
                'aint nobody got time fo dat',
            ),
            Clementia\Tester::TYPE_ELEMENT => array(
                'nonexistent-id',
                'superduperheader',
                'notanid',
            ),
        ),
    );

    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        $number_tests = 25;
        $test_types = array_keys(IoC::resolve('tester')->get_types());
        $lorem_url = 'https://baconipsum.com/api/?type=meat-and-filler&sentences=1&start-with-lorem=0';

        for ($i = 0; $i < $number_tests; $i++) {
            $test = new Test();
            $test->skip_limit_check = TRUE;
            $test->description = json_decode(file_get_contents($lorem_url))[0];

            $test->type = $test_types[array_rand($test_types)];
            $test->user_id = 2;
            $test->url = 'http://dhwebco.com';

            $valid_or_invalid_sample_tests = $this->sample_tests[array_rand($this->sample_tests)][$test->type];

            $value = $valid_or_invalid_sample_tests[array_rand($valid_or_invalid_sample_tests)];

            if ($test->type == Clementia\Tester::TYPE_TEXT) {
                $options = array('text' => $value);
            } elseif ($test->type == Clementia\Tester::TYPE_ELEMENT) {
                $options = array('id' => $value);
            }
            
            $test->options = $options;
            $test->save();
        }
    }
}