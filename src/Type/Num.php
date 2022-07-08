<?php

namespace Af\Type;

class Num extends Variable {

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

}
