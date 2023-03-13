<?php

namespace Af\Type;

use \Codeception\AssertThrows;

class StrTest extends \Codeception\Test\Unit {

    use AssertThrows;

    public function testValid() {
        $str = new Str();
        expect($str->isValid('string'))->toBeTrue();
        expect($str->isValid(2))->toBeTrue();
        expect($str->isValid(2.4))->toBeTrue();
        expect($str->isValid([1, 2]))->toBeFalse();
        expect($str->isValid(new \stdClass()))->toBeFalse();
        expect($str->isValid(new Str()))->toBeTrue();
    }
    
    public function testEnsureIsValid() {
        $this->assertThrows(Exception::class, function() {
            new Str([]);
        });
    }
    
    public function testLcase() {
        expect((new Str('TEstÉ'))->lcase()->get())->toEqual('testé');
    }

    public function testUcase() {
        expect((new Str('TEsté'))->ucase()->get())->toEqual('TESTÉ');
    }

    public function testCapitalize() {
        expect((new Str("tEst uc\twords é"))->capitalize()->get())->toEqual("Test Uc\tWords É");
    }
    
    public function testExplode() {
        expect((new Str("test-explode--items"))->explode('-')->get())->toEqual([
            'test', 'explode', '', 'items'
        ]);
    }

    public function testSplit() {
        expect((new Str('AT-CR'))->split('-')->get())->toEqual(['AT', 'CR']);
    }
    
    public function testToString() {
        $str = new Str('yes');
        expect("$str")->toEqual('yes');
    }
    
    public function testJsonDecode() {
        expect((new Str('1245'))->jsonDecode())->toEqual(1245);
        expect((new Str('{"foo": "bar"}'))->jsonDecode())->baseObjectToHaveAttribute('foo');
        expect((new Str('{"foo": "bar"}'))->jsonDecode(true))->toBeArray();
    }
    
}
