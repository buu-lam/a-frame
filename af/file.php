<?php
namespace af;
/**
 * Description of file
 *
 *
 * nodes:
 */
class file extends \node
{
    /**
     *
     * @var \af\file 
     */
    protected static $instance = false;

    public static function singleton()
    {
        return static::$instance ?: (static::$instance = new static);
    }
    
    /**
     * 
     * @param string $path
     * @return \file\infos|mixed
     */
    public function __get($path)
    {
        if (\file_exists($path))
        {
            return $this->$path = new \file\infos($this, $path);
        }
        else
        {
            return parent::__get($path);
        }
    }
}

