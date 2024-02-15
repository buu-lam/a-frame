<?php

namespace Af\Type\Format;

trait Sort {

    public function sort(int $flags = SORT_REGULAR) {
        sort($this->value, $flags);
        return $this;
    }

    public function rSort(int $flags = SORT_REGULAR) {
        rsort($this->value, $flags);
        return $this;
    }
    
    public function krSort(int $flags = SORT_REGULAR) {
        krsort($this->value, $flags);
        return $this;
    }
    
    public function natSort() {
        natsort($this->value);
        return $this;
    }

    public function uSort($callback) {
        usort($this->value, $callback);
        return $this;
    }
    
    public function ukSort($callback) {
        uksort($this->value, $callback);
        return $this;
    }
}
