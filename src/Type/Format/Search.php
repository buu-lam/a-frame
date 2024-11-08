<?php

namespace Af\Type\Format;

trait Search {

    public function pregMatch(string $pattern, array &$matches = null, int $flags = 0, int $offset = 0) {
        return preg_match($pattern, $this->value, $matches, $flags, $offset);
    }
    
    public function pregPick(string $pattern, int $matcher = 0, int $flags = 0, int $offset = 0) {
        return $this->cloned(
            preg_match($pattern, $this->value, $matches, $flags, $offset) ? 
            $matches[$matcher] : 
            ''
        );
    }

    public function pregReplace($from, $to = null) {
        $hasAssoc = is_array($from) && !isset($to);
        $search = $hasAssoc ? array_keys($from) : $from;
        $replace = $hasAssoc ? array_values($from) : $to;

        return $this->cloned(
                preg_replace($search, $replace, $this->value)
        );
    }
    
    public function pregReplaceCallbacks($assoc, int $limit = -1, int &$count = null, int $flags = 0) {
        return $this->cloned(
                preg_replace_callback_array($assoc, $this->value, $limit, $count, $flags)
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

    public function withExtension($extension) {
        return $this->cloned(
                str_contains($this->value, '.') ?
                    preg_replace('~\.([^.]+)$~', ".$extension", $this->value) :
                    "$this->value.$extension"
        );
    }
    
    public function noExtension() {
        return $this->cloned(
                preg_replace('~\.([^.]+)$~', '', $this->value)
        );
    }
    
    public function contains(string $string): bool {
        return str_contains($this->value, $string);
    }

    public function startsWith(string $string): bool {
        return str_starts_with($this->value, $string);
    }

    public function endsWith(string $string): bool {
        return str_ends_with($this->value, $string);
    }

}
