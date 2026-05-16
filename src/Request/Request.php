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

    public function offsetExists(mixed $offset): bool {
        return isset($this->value[$offset]);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->value[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        $this->value[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->value[$offset]);
    }

    public function rewind(): void {
        reset($this->value);
    }

    public function current(): mixed {
        return current($this->value);
    }

    public function key(): mixed {
        return key($this->value);
    }

    public function next(): void {
        next($this->value);
    }

    public function valid(): bool {
        $key = key($this->value);
        return $key !== null && $key !== false;
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
