<?php

namespace Af\Request;

class SessionTest extends \Codeception\Test\Unit {

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

}
