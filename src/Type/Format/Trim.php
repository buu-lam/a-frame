<?php

namespace Af\Type\Format;

trait Trim {

    public static $defaultTrimCharacters = " \n\r\t\v\x00";

    public function trim($characters = null) {
        return $this->cloned(
                trim($this->value, $characters ?? static::$defaultTrimCharacters)
        );
    }

    public function lTrim($characters = null) {
        return $this->cloned(
                ltrim($this->value, $characters ?? static::$defaultTrimCharacters)
        );
    }
    
    public function rTrim($characters = null) {
        return $this->cloned(
                rtrim($this->value, $characters ?? static::$defaultTrimCharacters)
        );
    }
}
