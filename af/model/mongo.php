<?php
namespace af\model;
/**
 * Description of model
 *
 * @author b.le
 * @method MongoCursor find(array $query = array(), array $fields = array())
 * @method array findOne(array $query = array())
 */
class mongo extends \type\data
{
    protected $refs         =   array();
    protected $ref_extend   =   array();
    
    public function __call($method, $arguments)
    {
        //flog($method);
        //flog($arguments);
        return call_user_func_array(array($this->coll, $method), $arguments);
    }
    
    public function collection_name()
    {
        $arr    =   explode('\\', get_class($this));
        return array_pop($arr);
    }
    
    public function db()
    {
        return $this->app->db;
    }
    
    public function coll()
    {
        return $this->db->{$this->collection_name};
    }
    
    public function save(&$row)
    {
        if (!isset($row))
        {
            return false;
        }
        
        method_exists($this, 'cast') && $this->cast($row);
        
        if (method_exists($this, 'validate') && $this->validate($row) !== true)
        {
            return false;
        }

        if (!isset($row['_id']) || !($row['_id'] instanceof \MongoId))
        { 
            $row['_id']     =   new \MongoId;
            $row[$this->collection_name] = $row['_ref'] = array(
                '$ref'  =>  $this->collection_name,
                '$id'   =>  $row['_id']
            );
            
            is_array($row['date']) || $row['date'] = array();
            
            $row['date']['create']    =   new \MongoDate;
            $row['date']['update']    =   new \MongoDate;
        }
        else
        {
            $row['date']['update']  =   new \MongoDate;
        }
        
        foreach ($this->ref_extend as $field)
        {
            $row[$this->collection_name][$field] = 
                $row['_ref'][$field] = 
                    $row[$field]
            ;
        }
        return $this->coll->save($row);
    }
    
    public function get4Id($id)
    {
        return $this->coll->findOne($this->_4Id($id));
    }
    
    public function _4Id($id)
    {
        return array('_id' => $id instanceof \MongoId ? $id : new \MongoId($id));
    }
    
    /**
     *
     * @return MongoCollection 
     */
    public function distinct($key, $query = array())
    {
        $distinct   =   $this->collection_name;
        
        $results    =   $this->db->command(
            compact('distinct', 'key', 'query')
        );
        
        return $results['values'];
    }
}
