<?php
namespace af;
/**
 * Description of tracking
 *
 * @author b.le
 * 
 * nodes:
 * @property af\track\session $session
 */
class track extends \node
{
    /**
     *
     * @var string 
     */
    protected $type         =   'session';
    protected $initialized;
    protected $ns;
    
    public function init()
    {
        $this->initialized  =   false;
        $this->{$this->type}->init();
        $this->initialized  =   true;
        return $this;
    }
    
    public function __isset($prop)
    {
        return isset($this->{$this->type}->$prop);
    }
    
    public function __unset($prop)
    {
        unset($this->{$this->type}->$prop);
        
    }
    
    public function __get($prop)
    {
        return $this->initialized
            ?   $this->{$this->type}->$prop
            :   parent::__get($prop)
        ;
    }
    
    public function __set($prop, $value)
    {
        $this->{$this->type}->$prop = $value;
    }
    
    /**
     * getter/setter
     * @param string $ns
     * @return string|\track
     */
    public function ns($ns = null)
    {
        return (isset($ns) && (($this->ns = $ns) || true)) ?
            $this : $this->ns
        ;
    }
    
    /**
     * getter/setter
     * you can switch of tracking type i.e pass session to cookie ...
     * 
     * @param string $type
     * @return string|\track
     */
    public function type($type = null)
    {
        return (isset($type) && (($this->type = $type) || true) && $this->init()) ?
            $this : $this->type
        ;
    }
}

