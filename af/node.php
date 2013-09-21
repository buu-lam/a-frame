<?php
namespace af;
/**
 * Description of \af\node
 *
 * @author b.le
 * @property string $_class classe de l'objet
 * @property string $_path chemin de l'objet
 * @property \app $app application à laquelle l'objet est rattaché
 */
class node
{
    /**
     * If true, prevents possible accidental uses of undeclared properties
     * @var boolean 
     */
    protected static $strict_get = false;
    
    /** 
     * Parent node this node is binded to.
     * @var \node  
     */
    public $dad;
    
    /**
     * Constructor. Takes in parameter 
     *
     * @param \node $dad
     */
    public function __construct($dad = null)
    {
        $this->dad = $dad;
        
        if (method_exists($this, 'init'))
        {
            $this->init();
        }
    }
    /**
     * Retourne le résultat de la méthode au même nom de variable,
     * ou par défaut, l'objet de la classe enfant
     * 
     * @param string $prop
     * @return mixed
     */
    public function __get($prop)
    {
        if (method_exists($this, $method = $prop))
        {
            return ($this->$prop = $this->$method());
        }
        else if (($class = $this->prop_class($prop)))
        {
            return $this->$prop = new $class($this);
        }
        else if (static::$strict_get)
        {
            $this->except('unknown property');
        }
    }
    
    public function prop_class($prop)
    {
        $dad_class =   $this->_class;
        
        do
        {
            if (class_exists($prop_class = $dad_class . '\\'. $prop))
            {
                return $prop_class;
            }
        }
        while ($dad_class = get_parent_class($dad_class));
        
        return false;
    }

    public function __call($prop, $params) 
    {
        if (($class = $this->prop_class($prop)))
        {
            switch(count($params))
            {
                case 0: return ($this->$prop = new $class($this));
                case 1: return ($this->$prop = new $class($this, $params[0]));
                case 2: return ($this->$prop = new $class($this, $params[0], $params[1]));
                case 3: return ($this->$prop = new $class($this, $params[0], $params[1], $params[2]));  
                case 4: return ($this->$prop = new $class($this, $params[0], $params[1], $params[2], $params[3]));  
                case 5: return ($this->$prop = new $class($this, $params[0], $params[1], $params[2], $params[3], $params[4]));
                default: $this->except('too many arguments');
            }
        }
        else
        {      
            $this->except('unknown method');
        }
    }

    public function app()
    {
        return $this->dad->app;
    }
    
    public function module()
    {
        return $this->dad->module;
    }
    
    /**
     * 
     * @param string $path
     * @return \view|boolean
     */
    public function view($path = '')
    {
        assert($path{0}=='/');
        
        $class =   \af\path2class('/view'.$path);
        
        if (class_exists($class))
        {
            return new $class($this);
        }
        else if (\af\file_exists('/template'.$path))
        {
            return new \view($this, $path);
        }
        else
        {
            return false;
        }
    }
    
    public function _class()
    {
        return get_class($this);
    }
    
    public function _path()
    {
        return str_replace('\\', '/', $this->_class);
    }
    
    public function _iscached($prop)
    {
        if(\file_exists($path = $this->app->path->cache.$this->_path.'/'.$prop))
        {
            include $path.'.php';
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function _cache($prop)
    {
        
    }
    
    /**
     * 
     * @param array|string $fields 
     * @return type
     */
    public function _2Inject($fields = array(), $_ = null)
    {
        is_string($fields) and $fields = func_get_args();

        $data   =   array();
        
        foreach($fields as $field)
        {
            $data[$field]   =   $this->$field;
        }
        
        return $data;
    }
    
    /**
     * 
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     * @return \Exception
     */
    public function except($message = '', $code = 0, \Exception $previous = NULL)
    {
        throw new \Exception($message, $code, $previous);      
    }
}
