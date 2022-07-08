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
}
