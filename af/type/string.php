<?php
namespace af\type;
/**
 * Description of string
 *
 * @author ble
 * @property-read \type\string $lower lower case
 * @method \type\string lower() lower case
 * @property-read \type\string $upper upper case
 * @method \type\string upper() upper case
 * @property-read \type\string $lcase lower case
 * @method \type\string lcase() lower case
 * @property-read \type\string $ucase upper case
 * @method \type\string ucase() upper case
 */
class string extends \type {
    
    protected $type = 'string';
    public static $transformations  =   array(
        'lower'     =>  'strtolower',
        'upper'     =>  'strtoupper',
        'lcase'     =>  'strtolower',
        'ucase'     =>  'strtoupper',
        'lcfirst'   =>  'lcfirst',
        'ucfirst'   =>  'ucfirst',
        'lcwords'   =>  'lcword',
        'ucwords'   =>  'ucwords',
        'trim'      =>  'trim',
        'ltrim'     =>  'ltrim',
        'rtrim'     =>  'rtrim'
        
    );
    
    public function __toString() 
    {
        return $this->value;
    }
    
    public function __get($prop)
    {
        return $this->transform($prop) ?: 
            parent::__get($prop)
        ;
    }
    
    public function __call($method, $params)
    {
        return $this->transform($method, $params) ?: 
            parent::__call($method, $params)
        ;
    }
    
    public function transform($key, $params = array())
    {
        if (isset(static::$transformations[$key]))
        {
            $func       =   static::$transformations[$key];
            
            switch(count($params))
            {
                case 0: $this->value = $func($this->value); break;
                case 1: $this->value = $func($this->value, $params[0]); break;
                default: assert(false);
            }
            
            return $this;
        }
        else
        {
            return false;
        }
    }


    /**
     * Replaces value
     * @param string|pattern $search
     * @param string $replace enables regex replace
     * @param boolean $regex
     * @return \type\string
     */
    public function replace($search, $replace, $regex = false)
    {
        $func   =   $regex  ?   'preg_replace' : 'str_replace';
        $this->value    =   $func($search, $replace, $this->value);
        
        return $this;
    }
    
    /**
     * Split value
     * @param type $glue
     * @param type $regex enables regex split
     * @return type
     */
    public function split($glue, $regex = false)
    {
        $func = $regex ? 'preg_split' : 'explode';
        return $func($glue, $this->value);
    }
    
    /**
     * 
     * @param type $string
     * @param string|array $batch
     * @param type $split
     * @return \type\string
     */
    public function __invoke($string, $batch = '', $split = '|')
    {
        $this->value = $string;
        
        if ($batch) {
            $this->batch($batch, $split);
        }
        
        return $this;
    }
    
    /** 
    * 
     * @return \type\string
     */
    public function dub()
    {
        return clone $this;
    }
    
    public function batch($batch, $split = '|')
    {
        is_array($batch) or $batch = explode($split, $batch);
        foreach ($batch as $transformation) 
        {
            $this->$transformation;
        }
        
        return $this;
    }
    
    public function camel($glue = '_')
    {
        return $this
            ->replace($glue, ' ')
            ->ucwords()
            ->replace(' ', '')
        ;
    }
    
    /**
     * 
     * @param string $glue
     * @return \type\string
     */
    public function lcamel($glue = '_')
    {
        return $this
            ->camel($glue)
            ->lcfirst()
        ;
    }
    
    /**
     * 
     * @param string $glue
     * @return \type\string
     */
    public function snake($glue = '_')
    {
        return $this
            ->replace('~([A-Z])~', ' $1', true)
            ->lcase()
            ->ltrim()
            ->replace(' ', $glue)
        ;
    }
}
