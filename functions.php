<?php

namespace {

    function useAfUnderscore() : bool {
        return useAf('_');
    }

    function useAf($function = 'af') : bool {
        if (!function_exists($function)) {
            function _($value) {
                return \Af\_($value);
            }
            return true;
        }
        return false;
    }
}

namespace Af {

    /**
     * 
     * @param mixed $value
     * @return \Af\Type\Variable|\Af\Type\Str|\Af\Type\Arr|\Af\Type\Num
     */
    function _($value = null) {
        if ($value instanceof Type\Variable) {
            return $value;
        } else if (is_string($value)) {
            return new Type\Str($value);
        } else if (is_array($value)) {
            return new Type\Arr($value);
        } else if (is_numeric($value)) {
            return new Type\Num($value);
        } else {
            return new Type\Variable($value);
        }
    }

    /**
     * 
     * @param string $value
     * @return \Af\Type\Str
     */
    function str($value) {
        return new Type\Str($value);
    }
    
    /**
     * 
     * @param array $value
     * @return \Af\Type\Arr
     */
    function arr($value) {
        return new Type\Arr($value);
    }
    
    /**
     * 
     * @param int|float $value
     * @return \Af\Type\Num
     */
    function num($value) {
        return new Type\Num($value);
    }
}


