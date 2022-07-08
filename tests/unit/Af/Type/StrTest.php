<?php

namespace Af\Type;

class StrTest extends \Codeception\Test\Unit {


    public function testValid() {
        $str = new Str();
        expect($str->isValid('string'))->toBeTrue();
        expect($str->isValid(2))->toBeTrue();
        expect($str->isValid(2.4))->toBeTrue();
        expect($str->isValid([1, 2]))->toBeFalse();
        expect($str->isValid(new \stdClass()))->toBeFalse();
        expect($str->isValid(new Str()))->toBeTrue();
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
}
