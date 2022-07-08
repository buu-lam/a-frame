<?php

namespace Af\DI;

class Fast extends Container {
        
    public function __get($id) {
        $this->ensureId($id);
        return $this->$id = $this->$id();
    }
}
