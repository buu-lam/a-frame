<?php
namespace af;
/**
 * Description of mock
 *
 * @author b.le
 */
class mock {
    /** @var hash|of|callable */
    public static $methods = array();
    
    /**
     * 
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        if (is_callable($this->$name)) {
            return call_user_func_array($this->$name, $arguments);
        }
    }
    
    /**
     * 
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        if (is_callable(static::$methods[$name])) {
            return call_user_func_array(static::$methods[$name], $arguments);
        }
    }
    
    /**
     * 
     * @param string $name
     * @param callable $function
     * @return \af\mock
     */
    public function method($name, $function) {
        $this->$name = $function;
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @param callable $function
     */
    public static function methodStatic($name, $function) {
        static::$methods[$name] = $function;
    }
}
