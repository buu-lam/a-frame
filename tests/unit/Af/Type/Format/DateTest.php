<?php

namespace Af\Type\Format;

use Af\Type\Num;
use \Af\Type\Str;

class DateTest extends \Codeception\Test\Unit {


    public function testDate() {
        expect((new Str('2024-01-01 -1day'))->date('Y-m')->get())->toBe('2023-12');       
    }
    
    public function testInterval() {
        expect((new Str('2024-01-01'))->date('Y-m-d')->interval('+1day')->get())->toBe('2024-01-02');
    }
    
    public function testTime() {
        expect((new Str('now'))->time())->toBe(time());
    }
}
