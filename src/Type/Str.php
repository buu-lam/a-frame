<?php

namespace Af\Type;

class Str extends Variable implements \ArrayAccess {

    use Format\Base64;
    use Format\Date;
    use Format\File;
    use Format\Padding;
    use Format\Search;
    use Format\Trim;

    protected $value = '';
    
    public function offsetExists(mixed $offset): bool {
        return isset($this->value[$offset]);
    }
    
    public function offsetGet(mixed $offset): mixed {
        return $this->value[$offset] ?? null;
    }
    
    public function offsetSet(mixed $offset, mixed $value): void {
        if (is_numeric($offset) || preg_match('~^(1-9)*$~')) {
            $this->value[$offset] = $value;
        }
    }
    
    public function offsetUnset(mixed $offset): void {
        unset($this->value[$offset]);
    }
    
    public function isValid($value): bool {
        if (is_string($value)) {
            return true;
        }
        if (is_numeric($value)) {
            return true;
        }
        if (!is_object($value)) {
            return false;
        }
        if (method_exists($value, '__toString')) {
            return true;
        }
        return false;
    }

    public function set($value): Str {
        $this->ensureIsValid($value);
        $this->value = "$value";
        return $this;
    }

    /**
     * All lower case
     * @return \Af\Type\Str
     */
    public function lcase(): Str {
        return $this->cloned(
                mb_strtolower($this->value)
        );
    }

    /**
     * All upper case
     * @return \Af\Type\Str
     */
    public function ucase(): Str {
        return $this->cloned(
                mb_strtoupper($this->value)
        );
    }

    /**
     * All word first letter upper case and left in lower case
     * @return \Af\Type\Str
     */
    public function capitalize(): Str {
        return $this->cloned(
                mb_convert_case($this->value, MB_CASE_TITLE)
        );
    }

    /**
     * into Array by separator
     * @param string $sep
     * @return \Af\Type\Arr
     */
    public function explode($sep): Arr {
        return new Arr(explode($sep, $this->value));
    }

    /**
     * into Array by str length (explode alias)
     * @param int $length = 1
     * @return \Af\Type\Arr
     */
    public function split(int $length = 1): Arr {
        assert($length >= 0);
        return new Arr(str_split($this->value, $length));
    }

    public function __toString() {
        return $this->value;
    }

    public function jsonDecode(bool $assoc = false, int $depth = 512, int $options = 0) {
        return json_decode($this->value, $assoc, $depth, $options);
    }
    
    public function prepend($string) {
        return $this->cloned($string . $this->value);
    }
    
    public function append($string) {
        return $this->cloned($this->value. $string);
    }
    
    /**
     * alias
     */
    public function prefix($string) {
        return $this->prepend($string);
    }
    
    /**
     * alias
     */
    public function dot($string) {        
        return $this->append($string);
    }
    
    /**
     * alias
     */
    public function concat($string) {
        return $this->append($string);
    }
    
    /**
     * alias
     */
    public function suffix($string) {
        return $this->append($string);
    }
    
    public function substr($offset, int $length = null) {
        return $this->cloned(substr($this->value, $offset, $length));
    }
    
    public function left(int $number = 1) {
        return $this->cloned(substr($this->value, 0, $number));
    }
    
    public function right(int $number = 1) {
        return $this->cloned(substr($this->value, -$number));
    }
}
