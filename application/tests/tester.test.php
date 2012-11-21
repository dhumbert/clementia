<?php

class TestTester extends PHPUnit_Framework_TestCase {

  public function setUp() {
    Bundle::start('composer');

    // stub out the request class
    $stub = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1>Hi!</h1></body></html>';
    $stub->shouldReceive('get')->andReturn($test_result);
    // set the requests object to be our stub
    IoC::instance('requests', $stub);
  }

	public function testThatLibraryExists() {
		$this->assertTrue(class_exists('Tester'));
	}

  public function testElementMatchingWithNoText() {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';

    $result = $tester->element($url, $element);
    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithNoText() {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'invalidelement';

    $result = $tester->element($url, $element);
    $this->assertFalse($result);
  }

  public function testElementMatchingWithText() {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';
    $text = 'Hi!';

    $result = $tester->element($url, $element, $text);
    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithText() {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';
    $text = 'This is not the right text.';

    $result = $tester->element($url, $element, $text);
    $this->assertFalse($result);
  }

}