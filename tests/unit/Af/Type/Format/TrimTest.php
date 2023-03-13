<?php

namespace Af\Type\Format;

use Af\Type\Str;

class TrimTest extends \Codeception\Test\Unit {
    public static $defaultTrimCharacters = " \n\r\t\v\x00";

    public function testTrim() {
        expect((new Str(' sfsf  '))->trim()->get())->toBe('sfsf');
        expect((new Str('~ sfsf  #~'))->trim('#~')->get())->toBe(' sfsf  ');
    }

    public function testLTrim() {
        expect((new Str(' sfsf  '))->lTrim()->get())->toBe('sfsf  ');
        expect((new Str('~ sfsf  #~'))->lTrim('#~')->get())->toBe(' sfsf  #~');
    }
    
    public function testRTrim($characters = null) {
        expect((new Str(' sfsf  '))->rTrim()->get())->toBe(' sfsf');
        expect((new Str('~ sfsf  #~'))->rTrim('#~')->get())->toBe('~ sfsf  ');
    }
}
