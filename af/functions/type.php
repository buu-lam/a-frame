<?php
namespace af;

/**
 * 
 * @param mixed $mix
 * @return int|bool
 */
function mix2int($mix)
{
    return is_int($mix) ? $mix :
        preg_match('~^-?\d+$~', $mix) ?
        (int) $mix : false
    ;
}