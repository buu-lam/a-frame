<?php
namespace af\db\mongo\document;
/**
 * Description of ref
 *
 *
 * nodes:
 */
class ref extends \db\mongo\document
{
    protected $data;
    protected $extended = false;
    
    public function __construct($dad, $data)
    {
        parent::__construct($dad, $data);
    }
    
    public function offsetGet($offset)
    { 
        if (isset($this->data[$offset]))
        {
            $value  =   $this->data[$offset];
            
            if (\MongoDBRef::isRef($value))
            {
                return $this->data[$offset] = $this->ref($value);
            }
            else if (is_array($value))
            {
                return $this->embed($value);
            }
            
            return $value;
        }
        else if (!$this->extended)
        {
            $this->extended =   true;
		    $data =  $this->db->getDBRef($this->data);
            if ($data)
            {
                $this->data =  array_merge($this->data, $data);
            }
            return $this->data[$offset];
        }
        else
        {
            return null;
        }
    }
}

