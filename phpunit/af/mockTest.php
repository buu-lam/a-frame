<?php

namespace af;

class mockTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var mock
     */
    protected $object;

    protected function setUp() {
        $this->object = new mock;
    }

    protected function tearDown() {
        
    }

    /**
     * @covers af\mock::__call
     */
    public function test__call() {
        $this->object->testCall = function() {
            return 'ok';
        };
        $this->assertEquals('ok', $this->object->testCall());
        
        $this->object->testCall2 = function($test) {
            return 2 * $test;
        };
        
        $this->assertEquals(4, $this->object->testCall2(2));
    }

    /**
     * @covers af\mock::__callStatic
     */
    public function test__callStatic() {
        $mock = $this->object;
        $mock->methodStatic('testStatic', function() {
            return 'static content';
        });
        $this->assertEquals('static content', $mock::testStatic());
    }

    /**
     * @covers af\mock::method
     */
    public function testMethod() {
        $this->object->method('testMethod', function() {
            return true;
        });
        
        $this->assertTrue($this->object->testMethod());
    }

    /**
     * @covers af\mock::methodStatic
     */
    public function testMethodStatic() {
        $mock = $this->object;
        $mock::methodStatic('testStatic', function() {
            return 'static content';
        });
        $this->assertEquals('static content', $mock::testStatic());
    }

    /**
     * @covers af\mock::emulateClass
     */
    public function testEmulateClass() {
        mock::emulateClass('test');
        $this->assertInstanceOf('test', new \test);
        
        mock::emulateClass('test1\\test2\\test3');
        $this->assertInstanceOf('test1\\test2\\test3', new \test1\test2\test3);
        
        mock::emulateClass('testvars', ['staticvar1', 'staticvar2']);
        \testvars::$staticvar1 = 2;
        \testvars::$staticvar2 = 4;
        $this->assertEquals(2, \testvars::$staticvar1);       
        $this->assertEquals(4, \testvars::$staticvar2);
    }

}
