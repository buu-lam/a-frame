<?php

namespace Af\Type;
use function Af\_;

class RegisterTest extends \Codeception\Test\Unit {

    
    public function testRegisterCall() {
        _()->register('concat123', function($var) {
           return $this->cloned($this->value . $var);
        });
        
        expect(_('a')->concat123('b')->get())->toBe('ab');
        
        expect(_(1)->concat123('b')->get())->toBe('1b');
    }
    
}
