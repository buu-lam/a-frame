<?php

namespace Af\DI;

class Strict {
    
    private $content = [];
    
    public function getShared($id) {
        return $this->content[$id];
    }
    
    public function __get($id) {
        if (isset($this->content[$id])) {
            return $this->content[$id];
        }
        $this->ensureId($id);
        return $this->content[$id] = $this->$id();
    }
}
