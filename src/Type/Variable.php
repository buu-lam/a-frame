<?php

namespace Af\Type;

class Variable {
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
     * @param type $value
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
    
    public function isA($class, $allow_string = false) : bool {
        return is_a($this->value, $class, $allow_string);
    }    

    public function isCallable() : bool {
        return is_callable($this->value);
    }

    public function isCountable() : bool {
        return is_countable($this->value);
    }
 
    public function isIterable() : bool {
        return is_iterable($this->value);
    }
    
    public function isNull() : bool {
        return is_null($this->value);
    }
        
    public function isNumeric() : bool {
        return is_numeric($this->value);
    }
    
    public function isSet() : bool {
        return isset($this->value);
    }

    public function isString() : bool {
        return is_string($this->value);
    }
    
    public function isEqualTo($value) : bool {
        return $this->value == ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function isIdenticalTo($value) : bool {
        return $this->value === ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function isLte($value) : bool {
        return $this->value <= ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function isGte($value) : bool {
        return $this->value >= ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function isGt($value) : bool {
        return $this->value > ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function isLt($value) : bool {
        return $this->value < ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function starship($value) : int {
        return $this->value <=> ($value instanceof Variable ? $value->get() : $value);
    }
    
    public function jsonEncode(int $flags = 0, int $depth = 512) : string {
        return json_encode($this->value, $flags, $depth);
    }
    
    public function jsonEncodePretty(int $flags = 0, int $depth = 512) : string {
        return $this->jsonEncode(JSON_PRETTY_PRINT | $flags, $depth);
    }
}
