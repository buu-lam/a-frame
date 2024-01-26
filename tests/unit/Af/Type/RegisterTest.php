<?php

namespace Af\Type;

class NumTest extends \Codeception\Test\Unit {

    
    public function testRound() {
        expect((new Num(3.6))->round()->get())
            ->toEqual(4);
        
        expect((new Num(3.67))->round(1)->get())
            ->toEqual(3.7);
        
        expect((new Num(-1.5))->round(0, PHP_ROUND_HALF_DOWN)->get())
            ->toEqual(-1);
    }
    
}
