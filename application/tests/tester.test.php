<?php

class TestTester extends PHPUnit_Framework_TestCase 
{
  private $_original_requests;
  private $_mocked_requests;

  public function setUp() 
  {
    Bundle::start('composer');

    $this->_original_requests = IoC::resolve('requests');
    // stub out the request class
    $this->_mocked_requests = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1>Hi!</h1><div class="alert">ALERT</div></body></html>';
    $this->_mocked_requests->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $this->_mocked_requests);
  }

  public function tearDown() 
  {
    IoC::instance('requests', $this->_original_requests);
  }

	public function testThatLibraryExists() 
  {
		$this->assertTrue(class_exists('Tester'));
	}

  public function testElementMatchingWithNoText() 
  {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';

    $result = $tester->element($url, $element);
    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithNoText() 
  {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'invalidelement';

    $result = $tester->element($url, $element);
    $this->assertFalse($result);
  }

  public function testElementMatchingWithText() 
  {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';
    $text = 'Hi!';

    $result = $tester->element($url, $element, $text);
    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithText() 
  {
    $tester = IoC::resolve('tester');

    $url = 'http://dhwebco.com';
    $element = 'h1';
    $text = 'This is not the right text.';

    $result = $tester->element($url, $element, $text);
    $this->assertFalse($result);
  }

}