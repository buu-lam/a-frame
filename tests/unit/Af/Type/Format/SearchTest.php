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

    public function testPregReplaceCallbacks() {
        expect((new Str('test123'))->pregReplaceCallbacks([
            '~(\d)~' => function($m) {
                return ($m[1] + 1);
            },
            '~[a-z]~' => function($m) {
                return strtoupper($m[0]);
            }
        ])->get())->toEqual('TEST234');
    }
    
    public function testReplace() {
        $str = new Str('ah i like alives');
        expect($str->replace('a', 'o')->get())->toBe('oh i like olives');
        expect($str->replace(['a' => 'o'])->get())->toBe('oh i like olives');
    }
    
    public function testWithExtension() {
        $withExt = new Str('file.txt');
        expect($withExt->withExtension('php')->get())->toBe('file.php');
        $with2Exts = new Str('file.inc.txt');
        expect($with2Exts->withExtension('php')->get())->toBe('file.inc.php');
        $noExt = new Str('file');
        expect($noExt->withExtension('php')->get())->toBe('file.php');
    }
    
    public function testNoExtension() {
        $withExt = new Str('file.txt');
        expect($withExt->noExtension()->get())->toBe('file');
        $with2Exts = new Str('file.inc.txt');
        expect($with2Exts->noExtension()->get())->toBe('file.inc');
        $noExt = new Str('file');
        expect($noExt->noExtension()->get())->toBe('file');
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
