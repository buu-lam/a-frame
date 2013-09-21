<?php

namespace af;

/**
 * \af\app class is the project tree root, the first node.
 * as a \af\node extension, it receives some additional methods
 * and specific child nodes (header, server, meta ...)
 *
 * @author b.le
 * 
 * nodes:
 * @property app\header $header
 * @property app\layout $layout
 * @property app\path $path
 * @property app\router\filesystem $router
 * @property app\server $server
 * @property app\topic $topic
 */
class app extends \node
{
    /** @var string  */
    public $dot;
    
    /** @var string  */
    public $url;

    /**
     * 
     * @return \app
     */
    public function app()
    {
        return $this;
    }

    /**
     * 
     * @return array
     */
    public function config()
    {
        $config =   new \config();
        return $config->ini;
    }

    /**
     * update the current param
     * @param string $dir
     * @return \app
     */
    public function dot($dir)
    {
        $path      = str_replace($this->router->dir, '', $dir);
        $url       = explode('/', $this->url);
        $this->dot = $url[count(explode('/', $path)) - 1];

        return $this;
    }

    public function router()
    {
        return new app\router\filesystem($this);
    }
    /**
     * 
     * @param string $url
     * @return \app
     */
    public function run($url = null)
    {
        $this->url  =   $url ?: $this->server->url;
        $this->router->run($this->url);
        $this->topic->is_set() or $this->topic->_404();

        method_exists($this, 'middleRun') && $this->middleRun();

        $this->header->html();

        if ($this->layout->is_set())
        {
            $this->view('/'.$this->layout)->render();
        }
        else if ($this->topic->is_set())
        {
            $this->view('/'.$this->topic)->render();
        }

        return $this;
    }
    
    public function bye($die = null)
    {
        die($die);
    }
    
    public function ok($data = array())
    {
        $ok = true;
        $this->header->json();
        die(json_encode(compact('ok', 'data')));
    }

    public function ko($error)
    {
        $ok = false;
        $this->header->json();
        die(json_encode(compact('ok', 'error')));
    }
    
    public function fileinfos()
    {
        return \file::singleton();
    }
    
    public function callFile($path)
    {
        $app    =   $this;
        include $path;
    }
}
