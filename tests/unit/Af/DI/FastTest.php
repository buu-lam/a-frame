<?php

namespace Af\DI;

class FastTest extends \Codeception\Test\Unit {

    use \Codeception\AssertThrows;

    /**
     * @var \UnitTester
     */
    protected $tester;
    private Fast $fast;

    public function _before() {
        $this->fast = new FastChild();
    }

    public function testGet() {
        expect($this->fast->get('yes'))->toBe('ok');
    }

    
    public function testGet__Failed() {
        $this->assertThrows(NotFoundException::class, function() {
            $this->fast->get('no');
        });
            
    }

    public function testMagicGet() {
        expect($this->fast->yes)->toBe('ok');
    }

}

/**
 * @property string $yes
 */
class FastChild extends \Af\DI\Fast {

    public function yes() {
        return 'ok';
    }

}
