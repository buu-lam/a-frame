<?php
namespace af;
/**
 * Description of type
 *
 * @author ble
 */
class type extends \node {
    
    /**
     * @var string 
     */
    protected $type;
    /**
     *
     * @var mixed stored value 
     */
    public $value;
    
    public function init()
    {
        assert(isset($this->type));
    }

    /**
     *
     * @return boolean
     */
    public function is_set()
    {
        return isset($this->value);
    }

    /**
     *
     * @return _property
     */
    public function un_set()
    {
        unset($this->value);
        return $this;
    }

    /**
     *
     * @param mixed $mix
     * @return _property
     */
    public function set($mix)
    {
        $this->isValid($mix) && ($this->value = $mix);
        //assert($l_boo);
        return $this;
    }

    /**
     *
     * @param mixed $mix
     * @return boolean
     */
    public function setIfValid($mix)
    {
        if ($this->isValid($mix))
        {
            $this->value    =   $mix;
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * retourne la valeur courante
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     *
     * @param mixed $mix
     * @return boolean
     */
    public function isValid($mix)
    {
        $check    =   'is_' . $this->type;

        if (function_exists($check))
        {
            return $check($mix);
        }
        else
        {
            return ($mix instanceof $this->type);
        }
    }
    
    
    /**
     *
     * @param mixed $mix
     * @return boolean
     */
    public function eq($mix)
    {
        return ($this->value == $mix);
    }
}
