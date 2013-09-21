<?php
namespace af\db\mongo;
/**
 * document class fakes to extend natives mongo documents.
 * array access allows developer to treat it seemless
 *
 *
 * nodes:
 * @property MongoDB $db Mongo Database
 */
class document extends \node implements \ArrayAccess, \Countable, \IteratorAggregate
{
    protected $data;

    public function __construct($dad, array &$data, MongoDB $db = null)
    {
        parent::__construct($dad);
        $this->data =   $data;
        $db && ($this->db = $db);
    }
    
    public function db()
    {
        return $this->app->db;
    }
    
    public function offsetGet($offset)
    { 
        if (isset($this->data[$offset]))
        {
            $value  =   $this->data[$offset];
            
            if (\MongoDBRef::isRef($value))
            {
                return $this->data[$offset] = new document\ref($this, $value);
            }
            else if (is_array($value))
            {
                return new document\embed($this, $value);
            }
            
            return $value;
        }
    }
    
    public function offsetSet($offset, $value)
    {
        if (isset($offset)) {
            $this->data[$offset] = $value;
        }
    }
    
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }
    
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
    
    /**
     * 
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
    
    public function getIterator() {
        return new ArrayIterator($this->data);
    }
}

