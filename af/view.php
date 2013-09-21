<?php
namespace af;
/**
 * Description of view
 * 
 * Views are equivalent to viewmodels. They include all possibles assignations,
 * calculations, data preparations and helpers for associated templates.
 * This way allows developers to not to prepare all datas in controllers
 * action methods. Disable a view 
 * 
 * Les views dans A-Frame se rapprochent de ce qu'on appelle les viewmodels.
 * Ces classes permettent d'encapsuler tous les calculs et autres préparations
 * de données destinées à remplir les templates php (ou autres) associés.
 * Le report de ces préparations permettent d'alléger les controleurs qui n'en
 * deviendront que plus lisibles. Par ailleurs il suffira de désactiver une vue
 * pour désactiver l'exécution de tous ces calculs, lors du rendu d'une url.
 *
 * @author b.le
 */
class view extends \node
{
    protected $_inject  =   array();
    
    /**
     * 
     * @param \node|\view $dad
     * @param string $path
     */
    public function __construct($dad = null, $path = null) {
        parent::__construct($dad);
        if ($path)
        {
            $this->_path    =   'template'.$path;
        }
    }
    
    /**
     * 
     * @param assoc $data
     * @return \af\view
     */
    public function inject($data)
    {
        $this->_inject  = array_merge_recursive($this->_inject, $data);
        return $this;
    }
    
    /**
     * assign key
     * @param string $key
     * @param mixed $val
     * @return \af\view
     */
    public function set($key, $val)
    {
        $this->_inject[$key]    =   $val;
        return $this;
    }
    
    /**
     * 
     * @param assoc $params
     * @return \af\view
     */
    public function params($params = array())
    {
        return $this;
    }
    
    
    public function __toString()
    {
        extract($this->_inject);
        
        include $this->path_template;
        
        return '';
    }
    
    /**
     * Returns path of associated template
     * @return string
     */
    public function path_template()
    {
        return \af::$app_dir . '/' . str_replace('view/', 'template/', $this->_path) . '.php';
    }
    
    /**
     * 
     * @param boolean $return
     * @return string|\af\view
     */
    public function render($return = false)
    {
        $return && ob_start();
        $this->__toString();
        return $return ? ob_get_clean() : $this;
    }
    
    /**
     * 
     * @param string $path
     * @return \af\view
     */
    public function view($path = '')
    {
        if ($path{0} == '/')
        {
            return parent::view($path);
        }
        else
        {
            $pfx    =   explode('/', $this->_path); $pfx[0] = '';
            $sfx    =   explode('/', $path);
            
            while($sfx[0] == '..')
            {
                array_shift($sfx);
                array_pop($pfx);
            }
            
            $pfx    =   implode('/', $pfx);
            $sfx    =   implode('/', $sfx);

            return parent::view($pfx.'/'.$sfx);
        }
    }
    
    /**
     * 
     * @param string $path
     * @return \af\view
     */
    public function __invoke($path = '')
    {
        return $this->view($path);
    }
    
    /**
     * 
     * @param string $path
     * @return string
     */
    public function topic_on($path)
    {
        return ($this->app->topic.'' == $path) ?
            'data-on=""' : ''
        ;
    }
}
