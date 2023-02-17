<?php

namespace Af\Type\Format;

trait Padding {

    public function pad($length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT) {
        return $this->cloned(
                str_pad($this->value, $length, $pad_string, $pad_type)
        );
    }

    public function lPad($length, $pad_string = ' ') {
        return $this->cloned(
                str_pad($this->value, $length, $pad_string, STR_PAD_LEFT)
        );
    }

    public function bPad($length, $pad_string = ' ') {
        return $this->cloned(
                str_pad($this->value, $length, $pad_string, STR_PAD_BOTH)
        );
    }

    public function rPad($length, $pad_string = ' ') {
        return $this->cloned(
                str_pad($this->value, $length, $pad_string, STR_PAD_RIGHT)
        );
    }

    public function numPad($length) {
        return $this->cloned(
                str_pad($this->value, $length, '0', STR_PAD_LEFT)
        );
    }

}
