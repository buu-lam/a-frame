<?php
namespace af\app;
/**
 * Description of path
 */
class path extends \node
{
    public static $dirs =   array('cache', 'cli', 'lib', 'route', 'template', 'view', 'www');

    public function __get($prop)
    {
        return $this->$prop = in_array($prop, static::$dirs) ?
            $this->getFullPath($prop) :
            parent::__get($prop)
        ;
    }
    
    protected function getFullPath($key)
    {
        $custom = isset($this->config[$key]) ? $this->config[$key] : null;
        
        if (!isset($custom))
        {
            return \af::$app_dir . DIRECTORY_SEPARATOR .  $key;
        }
        else if (DIRECTORY_SEPARATOR == '/' && $custom{0} == '/')
        {
            return $custom;
        }
        else if (DIRECTORY_SEPARATOR == '\\' && $custom{1} == ':' && $custom{2} == '\\')
        {
            return $custom;
        }
        else
        {
            return \af::$app_dir . DIRECTORY_SEPARATOR .  $key;
        }
    }
    
    public function config()
    {
        return isset($this->app->config['path']) ?
            $this->app->config['path'] :
            array()
        ;
    }
    
    public function __toString()
    {
        return \af::$app_dir;
    }
}

