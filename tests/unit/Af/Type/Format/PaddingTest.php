<?php

namespace Af\Type\Format;

use Af\Type\Str;

class PaddingTest extends \Codeception\Test\Unit {

    public function testPad() {
        expect((new Str('zz'))->pad(5)->get())->toBe('zz   ');
        expect((new Str('zz5fsddds'))->pad(5)->get())->toBe('zz5fsddds');
        expect((new Str('zz'))->pad(5, '#')->get())->toBe('zz###');
        expect((new Str('zz'))->pad(5, '#', STR_PAD_LEFT)->get())->toBe('###zz');
    }

    public function testLPad() {
        expect((new Str('zz'))->lPad(5)->get())->toBe('   zz');
        expect((new Str('zz5fsddds'))->lPad(5)->get())->toBe('zz5fsddds');
        expect((new Str('zz'))->lPad(5, '#')->get())->toBe('###zz');
    }

    public function testBPad() {
        expect((new Str('zz'))->bPad(5)->get())->toBe(' zz  ');
        expect((new Str('zz5fsddds'))->bPad(5)->get())->toBe('zz5fsddds');
        expect((new Str('zz'))->bPad(5, '#')->get())->toBe('#zz##');
    }

    public function testRPad() {
        expect((new Str('zz'))->rPad(5)->get())->toBe('zz   ');
        expect((new Str('zz5fsddds'))->rPad(5)->get())->toBe('zz5fsddds');
        expect((new Str('zz'))->rPad(5, '#')->get())->toBe('zz###');
    }

    public function testNumPad() {
        expect((new Str('123'))->numPad(5)->get())->toBe('00123');
        expect((new Str('12345678'))->numPad(5)->get())->toBe('12345678');
    }

}
