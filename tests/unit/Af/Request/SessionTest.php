<?php

namespace Af\Request;
use \Codeception\AssertThrows;
use \Prophecy\PhpUnit\ProphecyTrait;

class SessionTest extends \Codeception\Test\Unit {

    use ProphecyTrait;
    use AssertThrows;
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
        
    }

    protected function _after() {
        
    }

    // tests
    public function testSet() {
        $session = new Session;
        $session->test = 'ok';
        expect($session->test)->toEqual('ok');
    }

    public function testId() {
        $raw = $this->prophesize(\Af\System\Raw\Session::class);
        $raw->start()->willReturn(true);
        $raw->id()->willReturn('ok');
        
        $session = new Session;
        $session->initWithRaw($raw->reveal());
        expect($session->id())->toEqual('ok');
    }
    
    public function testEnsure() {

        $raw = $this->prophesize(\Af\System\Raw\Session::class);
        $raw->start()->willReturn(true);
        $raw->id()->willReturn('ensure-does-not-throw-exception');
        
        $session = new Session;
        $session->initWithRaw($raw->reveal());
        $session->ensure();
        
         
        $this->assertThrows(Exception::class, function() {
            $session = new Session;
            $session->ensure();
        });
    }
}
