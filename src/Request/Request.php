<?php

namespace Af\Request;

class Request implements \ArrayAccess, \Iterator {

    protected bool $settable = false;

    /** @var hash|of|mixed */
    protected $value;

    public function __construct($value = null) {
        $this->value = $value;
        $this->onInit();
    }

    public function onInit() {
        
    }
    
    public function bind(&$value) {
        $this->value = &$value;
    }

    public function offsetExists($offset): bool {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset) {
        return $this->value[$offset];
    }

    public function offsetSet($offset, $value): void {
        $this->value[$offset] = $value;
    }

    public function offsetUnset($offset): void {
        unset($this->value[$offset]);
    }

    public function rewind() {
        reset($this->value);
    }

    public function current() {
        $var = current($this->value);
        return $var;
    }

    public function key() {
        $var = key($this->value);
        return $var;
    }

    public function next() {
        $var = next($this->value);
        return $var;
    }

    public function valid() {
        $key = key($this->value);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function get($name) {
        return $this->value[$name] ?? null;
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function set($name, $value) {
        if (!$this->settable) {
            throw new Exception('set value is not allowed');
        }
        $this->value[$name] = $value;
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

    public function __isset($name) {
        return isset($this->value[$name]);
    }

}
