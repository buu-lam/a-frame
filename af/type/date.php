<?php
namespace af\type;
/**
 * Description of date
 *
 * 
 * nodes:
 */
class date extends \type
{
    public static $default_format = 'Y-m-d H:i:s';
    
    public $type = 'date';
    public $formats_generated = array();
    
    public function isValid($mix)
    {
        return \af\mix2int($mix) !== false;
    }
    
    public function parse($string, $format = 'Y-m-d H:i:s')
    {
        if (is_int($time = strtotime($string)))
        {
            $this->value = $time;
        }
        
        return $this;
    }
    
    public function format($format = false)
    {
        return \date(
            $format ?: static::$default_format, 
            is_int($this->value) ? $this->value : time()
        );
    }
    
    public function __get($format)
    {
        return parent::__get($format) ?: (
            $this->$format = (($this->formats_generated[] = $format) ? 
            $this->format($format) : false)
        );
    }
    
    public function __toString()
    {
        return $this->format();
    }
}

