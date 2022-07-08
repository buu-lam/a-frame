<?php

namespace Af\Type;

class Arr extends Variable {

    protected $value = [];

    public function extract(...$keys) {
        return array_map(function ($key) {
            return $this->value[$key];
        }, $keys);
    }

    public function filter($callback = null, $flag = 0) {
        return $this->cloned(array_filter($this->value, $callback, $flag));
    }

    public function implode($glue) {
        return new Str(implode($glue, $this->value));
    }

    public function inArray($item, bool $strict = false) {
        return in_array($item, $this->value, $strict);
    }

    public function join($glue) {
        return $this->implode($glue);
    }

    public function keyExists($key) {
        return array_key_exists($key, $this->value);
    }

    public function map($callback) {
        return $this->cloned(array_map($callback, $this->value));
    }

    public function pop() {
        return array_pop($this->value);
    }

    public function push(...$params) {
        foreach ($params as $param) {
            array_push($this->value, $param);
        }
        return $this;
    }

    public function search($needle, bool $strict = false) {
        return array_search($needle, $this->value, $strict);
    }

    public function shift() {
        return array_shift($this->value);
    }

    public function unique(int $flags = SORT_STRING) {
        return $this->cloned(array_unique($this->value, $flags));
    }

    public function unshift(...$params) {
        foreach (array_reverse($params) as $param) {
            array_unshift($this->value, $param);
        }
        return $this;
    }

    public function values() {
        return $this->cloned(array_values($this->value));
    }

}
