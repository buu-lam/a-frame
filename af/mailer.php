<?php
namespace af;
/**
 * Description of mailer
 *
 * @author b.le
 */
class mailer extends \node
{
    protected $libmail;
    protected $_inject = array();
    protected $path_yaml;


    public function init()
    {
        $this->libmail  =   new \libmail();
    }
    
    /**
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->libmail, $method), $arguments) ?: $this;
    }
    
    /**
     * 
     * @param string $path
     * @return \af\mailer
     */
    public function path_yaml($path)
    {
        $this->path_yaml =   \af::$app_dir . '/mail' . $path . '.yml';
        assert(\file_exists($this->path_yaml));
        return $this;
    }
    
    /**
     * 
     * @param assoc $data
     * @return \af\mailer
     */
    public function inject($data)
    {
        $this->_inject  = array_replace_recursive($this->_inject , $data);
        return $this;
    }
    
    /**
     * 
     * @return bool
     */
    public function send()
    {
        if ($this->path_yaml)
        {
            extract($this->_inject);
            ob_start();
            include $this->path_yaml;
            $this->config = \Symfony\Component\Yaml\Yaml::parse(ob_get_clean());
            flog($this->config);
            foreach($this->config as $method => $val)
            {
                $this->libmail->$method($val);
            }
        }
        
        return $this->libmail->send();
    }
}
