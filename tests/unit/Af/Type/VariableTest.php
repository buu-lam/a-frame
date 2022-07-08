<?php

namespace Af\Type;

class VariableTest extends \Codeception\Test\Unit {

    public function testGet() {
        expect((new Variable)->get())->toBeNull();
        expect((new Variable(2))->get())->toEqual(2);
    }

    public function testSet() {
        expect((new Variable)->set(3)->get())->toEqual(3);
    }
    
    public function testCloned() {
        $var = new Variable;
        $clone = $var->cloned(3);
        expect($clone)->notToEqual($var);
        expect($clone->get())->toEqual(3);
    }
}
