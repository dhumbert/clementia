<?php

class TestTester extends PHPUnit_Framework_TestCase 
{
  private $_original_requests;

  public function __construct() {
    $this->_original_requests = IoC::resolve('requests');
    parent::__construct();
  }

  public function setUp() 
  {
    Bundle::start('composer');
    // reset IoC container for each test
    IoC::instance('requests', $this->_original_requests);
  }

	public function testThatLibraryExistsAndIsAutoloaded() 
  {
		$this->assertTrue(class_exists('Tester'));
	}

  public function testWhatHappensWhenRequestBreaks() 
  {
    // stub out the request class
    $mock = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 404;
    $test_result->body = '404 error';
    $mock->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $mock);

    $tester = IoC::resolve('tester');
    $result = $tester->test('element', 'http://google.com', array(
      'element' => 'h1',
    ));
    $this->assertFalse($result);
  }

  public function testElementMatchingWithNoText() 
  {
    // stub out the request class
    $mock = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1></h1></body></html>';
    $mock->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $mock);

    $tester = IoC::resolve('tester');

    $result = $tester->test('element', 'http://dhwebco.com', array(
      'element' => 'h1',
    ));

    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithNoText() 
  {
    // stub out the request class
    $mock = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1></h1></body></html>';
    $mock->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $mock);

    $tester = IoC::resolve('tester');

    $result = $tester->test('element', 'http://dhwebco.com', array(
      'element' => 'invalidelement',
    ));

    $this->assertFalse($result);
  }

  public function testElementMatchingWithText() 
  {
    // stub out the request class
    $mock = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1>Hi!</h1></body></html>';
    $mock->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $mock);

    $tester = IoC::resolve('tester');

    $result = $tester->test('element', 'http://dhwebco.com', array(
      'element' => 'h1',
      'text' => 'Hi!',
    ));

    $this->assertTrue($result);
  }

  public function testInvalidElementMatchingWithText() 
  {
    // stub out the request class
    $mock = Mockery::mock('ClementiaRequest');

    $test_result = new stdClass;
    $test_result->status_code = 200;
    $test_result->body = '<html><body><h1>Some Text</h1></body></html>';
    $mock->shouldReceive('get')->andReturn($test_result);

    // set the requests object to be our stub
    IoC::instance('requests', $mock);

    $tester = IoC::resolve('tester');

    $result = $tester->test('element', 'http://dhwebco.com', array(
      'element' => 'h1',
      'text' => 'This is not the right text',
    ));

    $this->assertFalse($result);
  }

}