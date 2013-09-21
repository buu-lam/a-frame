<?php
namespace af\app\router;
/**
 * Description of filesystem
 *
 * @author b.le
 */
class filesystem extends \node
{
    public static $dot_php      =   'dot.php';
    public static $index_php    =   'index.php';
    
    protected $pattern;
    protected $url;
    
    public function run($url)
    {
        if (($this->pattern = $this->get($url)))
        {
            $this->app->callFile($this->dir.DIRECTORY_SEPARATOR.$this->pattern);
        }
    }

    public function get($url)
    {
        $dir    =   '/'.ltrim(rtrim($url, '/').'/'.static::$index_php, '/');

        foreach($this->routes as $route)
        {
            if (preg_match('#^/'.$route.'$#', $dir))
            {
                return $route;
            }
        }
        return false;
    }
    
    public function routes()
    {
        $oldcwd = getcwd();
        chdir($this->dir);
        $level  =   '';
        $routes =   array();
        
        while($dirs = glob($level.static::$index_php))
        {
            $routes = array_merge($routes, $dirs);
            $level .='*/';
            
        }
        chdir($oldcwd);

        return $routes;
    }
    
    public function map()
    {
        $map    =   array();
        $offset =   - \strlen(static::$index_php);
        $files  =   \file::singleton();

        foreach($this->routes as $route)
        {
            if (($url = $files->{"$this->dir/$route"}->route))
            {
                $map[$url]  =   substr($route, 0, $offset); 
            }
        }

        return $map;
    }
    
    /**
     * 
     * @return string
     */
    public function dir()
    {
        return $this->app->path->route;
    }
}
