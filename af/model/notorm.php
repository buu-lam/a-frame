<?php
namespace af\model;
/**
 * Description of notorm
 *
 * @author b.le
 */
class notorm extends \node
{
    protected $field_create;
    protected $field_update;
    protected $field_delete;
    
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->coll, $method), $arguments);
    }
    
    public function collection_name()
    {
        $arr    =   explode('\\', get_class($this));
        return end($arr);
    }
    
    public function coll()
    {
        return new NotORM_Result;
    }
    
    public function save(&$row)
    {
        method_exists($this, 'cast') && $this->cast($row);
        
        if (!isset($row['id']))
        { 
            $this->field_create and ($row[$this->field_create] = $this->literal('now()'));
        }
        else
        {
            $this->field_update and ($row[$this->field_update] = $this->literal('now()'));
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
    
    public function literal($value)
    {
        return new \NotORM_Literal($value);
    }
}
