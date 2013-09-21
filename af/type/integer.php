<?php
namespace af\type;
/**
 * Description of integer
 */
class integer extends \type
{
    protected $type = 'integer';
    
    public function __toString() 
    {
        return $this->value.'';
    }
}

