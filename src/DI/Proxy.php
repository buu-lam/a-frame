<?php

namespace Af\DI;

use Psr\Container\ContainerInterface;

class Proxy implements ContainerInterface {
    
    /** @var ContainerInterface */
    private $container;
    private $content = [];
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    /**
     * 
     * @param string $id
     * @return mixed 
     */
    public function get($id) {
        return $this->container->get($id);
    }
    
    public function has($id): bool {
        return $this->container->has($id);
    }
    
    public function __get($id) {
        return $this->content[$id] ?? ($this->content[$id] = $this->get($id));
    }
}
