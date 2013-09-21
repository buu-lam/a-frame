<?php

namespace af\app;

/**
 * Description of topic
 *
 * @author ble
 */
class viewpath extends \type\string
{
    protected $prefix = '';
    protected $suffix = '';
    protected $locked = false;
    
    public function isValid($mix)
    {
        if ($this->locked)
        {
            return false;
        }
        else if (parent::isValid($mix))
        {
            $path   =   $this->prefix . $mix . $this->suffix;
            return \af\file_exists('/view/' . $path) ||
                \af\file_exists('/template/' . $path)
            ;
        }
        else
        {
            debug_print_backtrace();
            return !print("no topic $mix");
        }
    }
    
    /**
     * 
     * @param string $prefix
     * @return string|viewpath
     */
    public function prefix($prefix = null)
    {
        return (isset($prefix) && (($this->prefix = $prefix) || true)) ?
            $this : $this->prefix
        ;
    }
    
    /**
     * 
     * @param string $suffix
     * @return string|viewpath
     */
    public function suffix($suffix = null)
    {
        return (isset($suffix) && (($this->suffix = $suffix) || true)) ?
            $this : $this->suffix
        ;
    }
    
    /**
     * différent de ->get()
     * @return string
     */
    public function __toString()
    {
        return $this->prefix . $this->value . $this->suffix;
    }
    
    public function sub($value)
    {
        return $this->set("$this->value/$value");
    }
    
    public function force($value)
    {
        $this->locked || $this->value = $value;
        return $this;
    }
    
    public function lock()
    {
        $this->locked   =   true;
        return $this;
    }
    
    public function unlock()
    {
        $this->locked   =   false;
        return $this;
    }
}
