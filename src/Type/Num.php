<?php

namespace Af\Type;

use \Af\Plugin;

class Num extends Variable {

    use Plugin\Num;

    protected $value = 0;

    /**
     * 
     * @param int $precision
     * @param int $mode
     * @return static
     */
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP) {
        return $this->cloned(
                round($this->value, $precision, $mode)
        );
    }

    public function numPad($length) {
        return $this->str()->numPad($length);
    }
}
