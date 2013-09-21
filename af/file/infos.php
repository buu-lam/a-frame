<?php
namespace af\file;
/**
 * Description of infos
 *
 *
 * nodes:
 */
class infos extends \node
{
    protected $path;
    
    public function __construct($dad, $path)
    {
        parent::__construct($dad);
        $this->path = $path;
    }
    
    public function route()
    {
        return $this->_prop(__FUNCTION__);
    }
    
    public function _prop($name)
    {
        return $this->dockblock && \preg_match("~\s*\*\s*@$name\s+([^\s]+)~", $this->dockblock, $matches) ?
            $matches[1] : false
        ;
    }
    
    public function dockblock()
    {
        $content    =   \file_get_contents($this->path);
        
        $start      =   \strpos($content, '/**') + 3;
        
        if ($start === FALSE) return false;
        
        $stop       =   \strpos($content, '*/', $start);
        
        return \substr($content, $start, $stop - $start);
    }
}

