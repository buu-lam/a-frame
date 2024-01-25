<?php

namespace Af\Type;

trait Register {

    protected static $registry = [];

    public function register($name, callable $callback) {
        static::$registry[$name] = $callback;
    }

    public function __call($name, $arguments) {
        return call_user_func_array(static::$registry[$name]->bindTo($this, $this), $arguments);
    }

}
