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
    
    public function testPregMatch() {
        expect((new Str('test123'))->pregMatch('~\d{3}~'))->toEqual(1);
        expect((new Str('test123'))->pregMatch('~\d{4}~'))->toEqual(0);
    }
    
    public function testPregReplace() {
        expect((new Str('test123'))->pregReplace('~\d{3}~', 'AAA')->get())->toEqual('testAAA');
    }
    
    
    public function testReplace() {
        $str = new Str('ah i like alives');
        expect($str->replace('a', 'o')->get())->toBe('oh i like olives');
        expect($str->replace(['a' => 'o'])->get())->toBe('oh i like olives');
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
    
    
    public function testPad() {
        expect((new Str('abc'))->pad(5)->get())->toEqual('abc  ');
        expect((new Str('abc'))->pad(6, '#')->get())->toEqual('abc###');
        expect((new Str('abc'))->pad(7, '#', STR_PAD_BOTH)->get())->toEqual('##abc##');
    }
    
    public function testLPad() {
        expect((new Str('abc'))->lPad(5)->get())->toEqual('  abc');
        expect((new Str('abc'))->lPad(6, '#')->get())->toEqual('###abc');
    }
    
    public function testBPad() {
        expect((new Str('abc'))->bPad(5)->get())->toEqual(' abc ');
        expect((new Str('abc'))->bPad(6, '#')->get())->toEqual('#abc##');
    }
    
    public function testRPad() {
        expect((new Str('abc'))->rPad(3)->get())->toEqual('abc');
        expect((new Str('abc'))->rPad(5)->get())->toEqual('abc  ');
        expect((new Str('abc'))->rPad(6, '#')->get())->toEqual('abc###');
    }
    
    public function testNumPad() {
        expect((new Str(159))->numPad(3)->get())->toEqual('159');
        expect((new Str('753'))->numPad(5)->get())->toEqual('00753');
    }
}
