<?php
namespace af\db\mongo\document;
debug_print_backtrace();
assert(!class_exists('\af\db\mongo\document\embed'));
/**
 * Description of embed
 *
 *
 * nodes:
 */
class embed extends \db\mongo\document implements \ArrayAccess
{
    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->data[] = $value;
        }
        else
        {
            $this->data[$offset] = $value;
        }
    }
    public function offsetGet($offset)
    { 
        if (isset($this->data[$offset]))
        {
            $value  =   $this->data[$offset];
            
            if (\MongoDBRef::isRef($value))
            {
                return $this->data[$offset] = new ref($this, $value);
            }
            else if (is_array($value))
            {
                return new embed($this, $value);
            }
            
            return $value;
        }
    }
}

