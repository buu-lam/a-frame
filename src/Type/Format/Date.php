<?php

namespace Af\Type\Format;

use Af\Type\Num;
use Af\Type\Str;

trait Date {

    protected string $dateFormat;
    protected int $dateTime;

    public function date($format) {
        $this->dateFormat = $format;
        return $this->cloned(
                date($this->dateFormat, $this->time())
        );
    }

    public function interval($delta) {
        $this->dateTime = strtotime("$delta", $this->time());
        return $this->cloned(
                date($this->dateFormat, $this->dateTime)
        );
    }

    public function time() {
        return $this->dateTime ?? ($this->dateTime = strtotime($this->value));
    }
}
