<?php

function useAfUnderscore() {
    if (!file_exists('_')) {
        function _($value) {
            return \Af\_($value);
        }
    }
}
    
namespace Af;

function _($value) {
    if (is_string($value)) {
        return new Type\Str($value);
    } else if (is_array($value)) {
        return new Type\Arr($value);
    } else if (is_numeric($value)) {
        return new Type\Num($value);
    } else {
        return new Af\Type\Variable($value);
    }
}
