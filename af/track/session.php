<?php
namespace af\track;

/**
 * Description of session
 *
 *
 * nodes:
 */
class session extends \node
{    
    /**
     * namespace
     * @var string
     */
    protected $ns;
    
    public function init()
    {
        session_start();
        
        $this->ns   =   $this->ns();
    }
    
    /**
     * namespace
     * @return string
     */
    public function ns()
    {
        return $this->dad->ns;
    }
    
    public function __isset($prop)
    {
        return isset($_SESSION[$this->ns.$prop]);
    }
    
    public function __unset($prop)
    {
        unset($_SESSION[$this->ns.$prop]);
    }
    
    public function __get($prop)
    {
        $nsprop =   $this->ns.$prop;
        
        if (isset($_SESSION[$nsprop]))
        {
            return $_SESSION[$nsprop];
        }
        else if (static::$strict_get)
        {
            $this->except("unknown session var $nsprop");
        }
    }
    
    public function __set($prop, $value)
    {
        $_SESSION[$this->ns.$prop] = $value;
    }
}

