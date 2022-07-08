<?php

namespace Af\System\Raw;

class Date {
    public function date($format, ?int $timestamp = null) {
        return date($format, $timestamp);
    }
}
