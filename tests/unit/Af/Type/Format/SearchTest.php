<?php

namespace Af\Type\Format;

use Af\Type\Str;

class SearchTest extends \Codeception\Test\Unit {

        
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
    
    public function testContains() {
        $str = new Str('ah i like alives');
        expect($str->contains('like'))->toBeTrue();
        expect($str->contains('likes'))->toBeFalse();
    }

    public function testStartsWith() {
        $str = new Str('ah i like alives');
        expect($str->startsWith('ah'))->toBeTrue();
        expect($str->startsWith('like'))->toBeFalse();
    }
    
    public function testEndsWith() {
        $str = new Str('ah i like alives');
        expect($str->endsWith('lives'))->toBeTrue();
        expect($str->endsWith('like'))->toBeFalse();
    }
}
