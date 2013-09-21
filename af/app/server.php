<?php
namespace af\app;
/**
 * Description of server
 *
 * @author b.le
 */
class server extends \node
{
    public function __get($prop)
    {
        $lower  =   strtolower($prop);
        $upper  =   strtoupper($prop);
        
        if (isset($_SERVER[$upper]))
        {
            return $this->$lower    =   $_SERVER[$upper];
        }
        else
        {
            return parent::__get($prop);
        }
    }
    
    public function is_ajax()
    {
        return $this->http_x_requested_with == 'XMLHttpRequest';
    }
    
    public function is_post()
    {
        return $this->request_method == 'POST';
    }
    
    public function is_get()
    {
        return $this->request_method == 'GET';
    }
    
    public function url()
    {
        $this->app || $this->except('method \af\server::url() need to be connected with an \af\app');
        
        $root   =   strlen($this->document_root);
        $len    =   strlen($this->app->path->www);
        $start  =   $len - $root + 1;
        $qs     =   strpos($this->request_uri, '?');
        return $qs ? substr($this->request_uri, $start, $qs - $start) : substr($this->request_uri, $start);
    }
}

