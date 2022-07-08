<?php

namespace Af\DI;

use Psr\Container\ContainerInterface;

abstract class Container implements ContainerInterface {
    
    /**
     * 
     * @param string $id
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id) {
        $this->ensureId($id);
        return $this->$id();
    }

    public function has($id): bool {
        return method_exists($this, $id);
    }
    
    protected function ensureId($id) : void {
        if (!$this->has($id)) {
            throw new NotFoundException("service '$id' not found.");
        }
    }
}
