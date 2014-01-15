<?php

class TestTester extends PHPUnit_Framework_TestCase 
{
    private $_original_requests;

    public function __construct()
    {
        $this->_original_requests = IoC::resolve('requests');
        parent::__construct();
    }

    public function setUp() 
    {
        Bundle::start('composer');
        // reset IoC container for each test
        IoC::instance('requests', $this->_original_requests);
    }

    public function testWhatHappensWhenRequestBreaks() 
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 404;
        $test_result->body = '404 error';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');
        $result = $tester->test('element', 'http://google.com', array(
            'tag' => 'h1',
        ));
        $this->assertFalse($result);
    }

    public function testElementMatchingWithNoText() 
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1></h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithNoText() 
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1></h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'invalidelement',
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithText() 
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1>Hi!</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'inner_text' => 'Hi!',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithText() 
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1>Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'inner_text' => 'This is not the right text',
        ));

        $this->assertFalse($result);
    }

    public function testInvalidElementMatchingWithID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1>Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithTagAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'id' => 'wrongid',
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithTagAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'id' => 'title',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithTextAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
            'inner_text' => 'Wrong Text',
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithTextAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
            'inner_text' => 'Some Text',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithTextTagAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
            'tag' => 'h2',
            'inner_text' => 'Wrong Text',
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithTextTagAndID()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 id="title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'id' => 'title',
            'tag' => 'h1',
            'inner_text' => 'Some Text',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithTagAndAttribute()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="red-title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'some-invalid-class',
            ),
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithTagAndAttribute()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="red-title">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'red-title',
            ),
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithTagAndMultipleAttributes()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="red-title" rel="external">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'red-title',
                'rel' => 'internal',
            ),
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithTagAndMultipleAttributes()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="red-title" rel="external">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'red-title',
                'rel' => 'external',
            ),
        ));

        $this->assertTrue($result);
    }

    public function testInvalidElementMatchingWithMultipleClasses()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'wrongclass',
            ),
        ));

        $this->assertFalse($result);
    }

    public function testElementMatchingWithMultipleClasses()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('element', 'http://dhwebco.com', array(
            'tag' => 'h1',
            'attributes' => array(
                'class' => 'hover',
            ),
        ));

        $this->assertTrue($result);
    }

    public function testInvalidTextMatchingCaseInsensitive()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('text', 'http://dhwebco.com', array(
            'text' => 'Text not present',
        ));

        $this->assertFalse($result);
    }

    public function testTextMatchingCaseInsensitive()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('text', 'http://dhwebco.com', array(
            'text' => 'SOME TEXT',
        ));

        $this->assertTrue($result);
    }

    public function testInvalidTextMatchingCaseSensitive()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('text', 'http://dhwebco.com', array(
            'text' => 'SOME Text',
            'case_sensitive' => TRUE,
        ));

        $this->assertFalse($result);
    }

    public function testTextMatchingCaseSensitive()
    {
        // stub out the request class
        $mock = Mockery::mock('ZafBoxRequest');

        $test_result = new stdClass;
        $test_result->status_code = 200;
        $test_result->body = '<html><body><h1 class="active hover">Some Text</h1></body></html>';
        $mock->shouldReceive('get')->andReturn($test_result);

        // set the requests object to be our stub
        IoC::instance('requests', $mock);

        $tester = IoC::resolve('tester');

        $result = $tester->test('text', 'http://dhwebco.com', array(
            'text' => 'Some Text',
            'case_sensitive' => TRUE,
        ));

        $this->assertTrue($result);
    }

}