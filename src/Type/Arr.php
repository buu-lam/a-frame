<?php

namespace Af\Type;

use Af\Plugin;

class Arr extends Variable implements \Countable, \ArrayAccess, \IteratorAggregate {

    use Format\Sort;
    use Plugin\Arr;

    protected $value = [];

    public function offsetExists(mixed $offset): bool {
        return array_key_exists($offset, $this->value);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->value[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->value[$offset]);
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->value);
    }

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
        return $this->hasValue($item, $strict);
    }

    public function hasValue($item, bool $strict = false) {
        return in_array($item, $this->value, $strict);
    }

    public function join($glue) {
        return $this->implode("$glue");
    }

    public function keyExists($key) {
        return $this->hasKey($key);
    }

    public function hasKey($key) {
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

    public function slice(int $offset, ?int $length = null, bool $preserve_keys = false) {
        return $this->cloned(
                array_slice($this->value, $offset, $length, $preserve_keys)
        );
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

    public function keys() {
        return $this->cloned(array_keys($this->value));
    }

    public function combine($values) {
        return $this->cloned(array_combine(
                    $this->value,
                    $values instanceof Variable ? $values->get() : $values
        ));
    }

    public function count(): int {
        return count($this->value);
    }

    public function ensureHasKeys(...$keys) {
        foreach ($keys as $key) {
            if (!$this->hasKey($key)) {
                throw new Exception("no key '$key' found");
            }
        }
    }

    public function ensureHasValues(...$values) {
        foreach ($values as $value) {
            if (!$this->hasValue($value)) {
                throw new Exception("no value '$value' found");
            }
        }
    }

    public function ensureHasStrictValues(...$values) {
        foreach ($values as $value) {
            if (!$this->hasValue($value, true)) {
                throw new Exception("no value '$value' found");
            }
        }
    }

    public function merge(... $arrays) {
        return $this->callWithArrays('array_merge', $arrays);
    }

    public function mergeRecursive(... $arrays) {
        return $this->callWithArrays('array_merge_recursive', $arrays);
    }

    public function replace(... $arrays) {
        return $this->callWithArrays('array_replace', $arrays);
    }

    private function callWithArrays($callback, $arrs) {
        $arrays = $arrs;
        array_unshift($arrays, $this->value);
        $final = call_user_func_array($callback, $arrays);
        return $this->cloned($final);
    }

    public function min(): mixed {
        return min($this->value);
    }

    public function max(): mixed {
        return max($this->value);
    }

    public function forEach($callback, $arg = null) {
        array_walk($this->value, $callback, $arg);
        return $this;
    }

    public function cherryPick(... $keys) {
        $filteredKeys = is_array($keys[0]) ? $keys[0] : $keys;
        $cherryPick = [];
        // array_intersect_key + array_flip doesn't ensure the same keys order.
        foreach ($filteredKeys as $filteredKey) {
            $cherryPick[$filteredKey] = $this->value[$filteredKey];
        }
        return $this->cloned($cherryPick);
    }
}
