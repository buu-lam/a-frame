<?php

namespace Af\Type;

use \Prophecy\PhpUnit\ProphecyTrait;

class VariableTest extends \Codeception\Test\Unit {

    use ProphecyTrait;
    
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
    
    public function testIsNull() {
        $null = new Variable(null);
        expect($null->isNull())->toBeTrue();
        
        $notNull = new Variable('50');
        expect($notNull->isNull())->toBeFalse();
    }
    
    public function testIsNumeric() {
        expect((new Variable())->isNumeric())->toBeFalse();
        expect((new Variable(123))->isNumeric())->toBeTrue();
        expect((new Variable(123.2))->isNumeric())->toBeTrue();
        expect((new Variable(1_582))->isNumeric())->toBeTrue();
        expect((new Variable(.582))->isNumeric())->toBeTrue();
        expect((new Variable('1582'))->isNumeric())->toBeTrue();
        expect((new Variable('158.2'))->isNumeric())->toBeTrue();
        expect((new Variable('0777'))->isNumeric())->toBeTrue();
        expect((new Variable('0-777'))->isNumeric())->toBeFalse();
        expect((new Variable('.777'))->isNumeric())->toBeTrue();
    }
    
    public function testIsSet() {
        $notNull = new Variable('50');
        expect($notNull->isSet())->toBeTrue();
        
        $null = new Variable(null);
        expect($null->isSet())->toBeFalse();
    }
    
    public function testIsString() {
        $string = new Variable('abc');
        expect($string->isString())->toBeTrue();
        
        $notString = new Variable(50);
        expect($notString->isString())->toBeFalse();
        
        $stringOfNumber = new Variable('50');
        expect($stringOfNumber->isString())->tobeTrue();
    }
    
    public function testIsEqualTo() {
        expect((new Variable('ab'))->isEqualTo('ab'))->toBeTrue();
        expect((new Variable('ab'))->isEqualTo((new Variable('ab'))))->toBeTrue();
        expect((new Variable(new \stdClass))->isEqualTo(new \stdClass))->toBeTrue();
    }
    
    public function testIsIdenticalTo() {
        expect((new Variable('ab'))->isIdenticalTo('ab'))->toBeTrue();
        expect((new Variable('ab'))->isIdenticalTo((new Variable('ab'))))->toBeTrue();
        expect((new Variable(new \stdClass))->isIdenticalTo(new \stdClass))->toBeFalse();
    }
    
    public function testIsA() {
        expect((new Variable())->isA(\stdClass::class))->toBeFalse();
        expect((new Variable(new \stdClass()))->isA(\stdClass::class))->toBeTrue();
        expect((new Variable(new Variable()))->isA(Variable::class))->toBeTrue();
    }
    
    public function testIsCallable() {
        expect((new Variable())->isCallable())->toBeFalse();
        expect((new Variable(function() {return false;}))->isCallable())->toBeTrue();
    }
    
    public function testIsCountable() {
        $a = $this->prophesize(\Countable::class);
        expect((new Variable($a->reveal()))->isCountable())->toBeTrue();
        expect((new Variable([1, 2]))->isCountable())->toBeTrue();
        expect((new Variable(['foo' => 'bar']))->isCountable())->toBeTrue();
    }
    
    public function testIsIterable() {
        $a = $this->prophesize(\Iterator::class);
        expect((new Variable($a->reveal()))->isIterable())->toBeTrue();
        expect((new Variable([1, 2]))->isIterable())->toBeTrue();
        expect((new Variable(['foo' => 'bar']))->isIterable())->toBeTrue();
    }

    public function testIsGte() {
        expect((new Variable('ab'))->isGte('aa'))->toBeTrue();
        expect((new Variable('ab'))->isGte('ab'))->toBeTrue();
        expect((new Variable('ab'))->isGte('ac'))->toBeFalse();
        expect((new Variable(2))->isGte(1))->toBeTrue();
        expect((new Variable(2))->isGte(2))->toBeTrue();
        expect((new Variable(2))->isGte(3))->toBeFalse();
    }
    
    public function testIsGt() {
        expect((new Variable('ab'))->isGt('aa'))->toBeTrue();
        expect((new Variable('ab'))->isGt('ab'))->toBeFalse();
        expect((new Variable('ab'))->isGt('ac'))->toBeFalse();
        expect((new Variable(2))->isGt(1))->toBeTrue();
        expect((new Variable(2))->isGt(2))->toBeFalse();
        expect((new Variable(2))->isGt(3))->toBeFalse();
    }
    
    public function testIsLte() {
        expect((new Variable('ab'))->isLte('aa'))->toBeFalse();
        expect((new Variable('ab'))->isLte('ab'))->toBeTrue();
        expect((new Variable('ab'))->isLte('ac'))->toBeTrue();
        expect((new Variable(2))->isLte(1))->toBeFalse();
        expect((new Variable(2))->isLte(2))->toBeTrue();
        expect((new Variable(2))->isLte(3))->toBeTrue();
    }
    
    public function testIsLt() {
        expect((new Variable('ab'))->isLt('aa'))->toBeFalse();
        expect((new Variable('ab'))->isLt('ab'))->toBeFalse();
        expect((new Variable('ab'))->isLt('ac'))->toBeTrue();
        expect((new Variable(2))->isLt(1))->toBeFalse();
        expect((new Variable(2))->isLt(2))->toBeFalse();
        expect((new Variable(2))->isLt(3))->toBeTrue();
    }
    
    public function testStarShip() {
        expect((new Variable('ab'))->starship('aa'))->toBe(1);
        expect((new Variable('ab'))->starship((new Variable('ab'))))->toBe(0);
        expect((new Variable('ab'))->starship('ac'))->toBe(-1);
    }
    
    public function testJsonEncode() {
        expect((new Variable('abc'))->jsonEncode())->toBe('"abc"');        
        expect((new Variable((object) ['foo' => 'bar']))->jsonEncode(JSON_PRETTY_PRINT))->toBe("{\n    \"foo\": \"bar\"\n}");
    }
    
    public function testJsonEncodePretty() {
        expect((new Variable('abc'))->jsonEncode())->toBe('"abc"');        
        expect((new Variable((object) ['foo' => 'bar']))->jsonEncodePretty())->toBe("{\n    \"foo\": \"bar\"\n}");
    }
}
