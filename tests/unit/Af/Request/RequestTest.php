<?php

namespace Af\Request;

class RequestTest extends \Codeception\Test\Unit {

    // tests
    public function testGet() {

        $request = new Request(['a' => 3]);
        expect($request->a)->toEqual(3);
        expect($request['a'])->toEqual(3);
    }
    
    public function testBind() {
        $test = ['a' => 3];
        $request = new Request();
        $request->bind($test);
        expect($request->a)->toEqual(3);
        expect($request['a'])->toEqual(3);
        $request->bind($test);
        $test['a'] = 4;

        expect($request['a'])->toEqual(4);
        expect($test['a'])->toEqual(4);
    }

    /**
     * @throws \Af\Request\Exception
     */
    public function testNotSet() {
        $test = ['a' => 3];
        $request = new Request($test);
//        $request->a = 4;
    }
}
