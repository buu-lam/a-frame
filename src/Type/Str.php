<?php

namespace Af\Type;

class Str extends Variable {

    use Format\Base64;
    use Format\File;
    use Format\Padding;
    
    protected $value = '';

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
     * into Array by separator (explode alias)
     * @param string $sep
     * @return \Af\Type\Arr
     */
    public function split($sep): Arr {
        return $this->explode($sep);
    }

    public function pregMatch(string $pattern, array &$matches = null, int $flags = 0, int $offset = 0) {
        return preg_match($pattern, $this->value, $matches, $flags, $offset);
    }

    public function pregReplace($from, $to = null) {
        $hasAssoc = is_array($from) && !isset($to);
        $search = $hasAssoc ? array_keys($from) : $from;
        $replace = $hasAssoc ? array_values($from) : $to;

        return $this->cloned(
                preg_replace($search, $replace, $this->value)
        );
    }

    public function replace($from, $to = null) {
        $hasAssoc = is_array($from) && !isset($to);
        $search = $hasAssoc ? array_keys($from) : $from;
        $replace = $hasAssoc ? array_values($from) : $to;

        return $this->cloned(
                str_replace($search, $replace, $this->value)
        );
    }

    public function __toString() {
        return $this->value;
    }

    public function jsonDecode(bool $assoc = false, int $depth = 512, int $options = 0) {
        return json_decode($this->value, $assoc, $depth, $options);
    }
}
