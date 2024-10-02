<?php

namespace Af\Type;

use \Af\Plugin;

class Variable {

    use Register;
    use Plugin\Variable;

    protected $type;
    protected $value;

    public function __construct($value = null) {
        if (isset($value)) {
            $this->set($value);
        }
    }

    public function set($value) {
        $this->ensureIsValid($value);
        $this->value = $value;
        return $this;
    }

    /**
     * 
     * @param mixed $value
     * @return boolean
     */
    public function isValid($value): bool {
        return true;
    }

    public function ensureIsValid($value) {
        if (!$this->isValid($value)) {
            throw new Exception('value is not valid');
        }
    }

    public function get() {
        return $this->value;
    }

    public function __invoke() {
        return $this->value;
    }

    /**
     * 
     * @param mixed $value
     * @return static
     */
    public function cloned($value) {
        $oldValue = $this->value;
        $this->value = $value;
        $cloned = clone $this;
        $this->value = $oldValue;
        return $cloned;
    }

    public function isA($class, $allow_string = false): bool {
        return is_a($this->value, $class, $allow_string);
    }

    public function isCallable(): bool {
        return is_callable($this->value);
    }

    public function isCountable(): bool {
        return is_countable($this->value);
    }

    public function isIterable(): bool {
        return is_iterable($this->value);
    }

    public function isNull(): bool {
        return is_null($this->value);
    }

    public function isNumeric(): bool {
        return is_numeric($this->value);
    }

    public function isSet(): bool {
        return isset($this->value);
    }

    public function isString(): bool {
        return is_string($this->value);
    }

    public function isEqualTo($value): bool {
        return $this->value == ($value instanceof Variable ? $value->get() : $value);
    }

    public function isIdenticalTo($value): bool {
        return $this->value === ($value instanceof Variable ? $value->get() : $value);
    }

    public function isLte($value): bool {
        return $this->value <= ($value instanceof Variable ? $value->get() : $value);
    }

    public function isGte($value): bool {
        return $this->value >= ($value instanceof Variable ? $value->get() : $value);
    }

    public function isGt($value): bool {
        return $this->value > ($value instanceof Variable ? $value->get() : $value);
    }

    public function isLt($value): bool {
        return $this->value < ($value instanceof Variable ? $value->get() : $value);
    }

    public function starship($value): int {
        return $this->value <=> ($value instanceof Variable ? $value->get() : $value);
    }

    public function jsonEncode(int $flags = 0, int $depth = 512): Str {
        return new Str(json_encode($this->value, $flags, $depth));
    }

    public function jsonEncodePretty(int $flags = 0, int $depth = 512): Str {
        return $this->jsonEncode(JSON_PRETTY_PRINT | $flags, $depth);
    }

    public function isIn($value, bool $strict = false) {
        if ($value instanceof Variable) {
            $value = $value->get();
        }
        if (is_array($value)) {
            return in_array($this->value, $value, $strict);
        }
        if (is_string($value) && (is_string($this->value) || is_numeric($this->value))) {
            return str_contains($value, "$this->value");
        }
        throw new Exception('values are not compatible');
    }

    public function str(): Str {
        return new Str((string) $this->value);
    }

    public function arr(): Arr {
        return new Arr((array) $this->value);
    }

    public function printR(bool $return = false) {
        $out = print_r($this->value, $return);
        return $return ? $out : $this;
    }

    public function apply(callable $func) {
        return $func($this);
    }
    
    public function run(callable $func) {
        $func->bindTo($this, $this)();
        return $this;
    }
}
