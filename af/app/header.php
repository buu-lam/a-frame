<?php
namespace af\app;
/**
 * Description of app_header
 *
 * @author b.le
 */
class header extends \node
{
    protected $is_ob    =   false;
    protected $header_ob;
    
    protected $cause = '';
    
    protected $extension;
    
    public function ob($i_boo = false)
    {
        $this->is_ob    =   $i_boo;
        return $this;
    }
    
    public function _header($i_str)
    {
        $this->is_ob ?
            ($this->header_ob[] = $i_str) : 
            header($i_str)
        ;
        return $this;
    }
    
    
    public function css()
    {
        return $this->_text(__FUNCTION__);
    }
    

    public function csv($i_filename = null)
    {
        return $this->_app('vnd.ms-excel')->_attach($i_filename);
    }

    public function html() 
    {
        return $this->_text(__FUNCTION__);
    }
    
    public function pdf()
    {
        return $this->_app(__FUNCTION__);
    }

    public function plain()
    {
        return $this->_text(__FUNCTION__);
    }

    public function xml()
    {
        return $this->_app(__FUNCTION__);
    }

    public function json()
    {
        return $this->_app(__FUNCTION__);
    }
    
    public function gif()
    {
        return $this->_image(__FUNCTION__);
    }

    public function jpeg()
    {
        return $this->_image(__FUNCTION__);
    }

    public function jpg()
    {
        return $this->jpeg();
    }

    public function png()
    {
        return $this->_image(__FUNCTION__);
    }

    public function txt()
    {
        return $this->plain();
    }
    
    public function xls($i_filename = null)
    {
        return $this->_app('vnd.ms-excel')->_attach($i_filename);
    }
    
    public function swf()
    {
        return $this->_app('x-shockwave-flash');
    }
    
    public function zip()
    {
        return $this->_app(__FUNCTION__);
    }

    public function _image($i_type)
    {
        $this->_header("content-type: image/$i_type");
        return $this;
    }

    public function js()
    {
        return $this->_apptext('x-javascript');
    }

    public function _text($i_type)
    {
        $this->_header("content-type: text/$i_type" . $this->_charset());
        return $this;
    }

    public function _app($i_type)
    {
        $this->_header("content-type: application/$i_type");
        return $this;
    }
    
    public function _apptext($i_type)
    {
        $this->_header("content-type: application/$i_type" . $this->_charset());
        return $this;
    }

    public function _charset()
    {
        return '; charset=utf-8';
    }
    
    public function _attach($i_filename = null)
    {
        if (isset($i_filename))
        {
            $this->_header("content-disposition: attachment; filename=\"$i_filename\"");
        }
        return $this;
    }

    public function _size($i_path = null)
    {
        if (isset($i_path))
        {
            $this->_header('content-length: ' . filesize($i_path));
        }
        return $this;
    }

    public function guess($i_filename, $i_booOb = false)
    {
        $l_type =   \array_pop(\explode('.', $i_filename));

        if (method_exists($this, $l_type))
        {
            $this->$l_type();
        }
        else
        {
            $this->plain();
        }
        
        $this->extension    =   $l_type;
        
        return $this;
    }

    public function guess4Mail($i_filename)
    {
        $this->ob(true);    
        $this->guess($i_filename);
        $this->ob(false);
        
        $o_header   =   implode("\r\n", $this->header_ob);
        $this->header_ob    =   array();
        
        return $o_header;
    }
    
    public function getExtension()
    {
        return $this->extension;
    }
    
    public function lastModified($i_time)
    {
        $l_date =   gmdate('d M Y H:i:s', $i_time);
        $this->_header("Cache-Control: must-revalidate");
        $this->_header("Last-Modified: $l_date GMT");
        return $this;
    }

    public function notModified()
    {
        $this->_header('HTTP/1.1 304 Not Modified');
        return $this;
    }

    public function checkHasNotCache($i_time)
    {
        $l_since    =   $_SERVER['HTTP_IF_MODIFIED_SINCE'];

        if (! isset($l_since) || empty($l_since) || ! is_int($l_since = strtotime($l_since)) || $l_since > $i_time)
        {
            $this->lastModified($i_time);
            return true;
        }
        else
        {
            $this->notModified();
            return false;
        }
    }

    public function length($i_length)
    {
        $this->_header("Content-Length: $i_length");
        return $this;
    }

    public function _301($i_cause = '')
    {
        $this->_header('HTTP/1.1 301 Moved Permanently');
        $this->cause = $i_cause;
        return $this;
    }

    public function _403($i_cause = '')
    {
        $this->_header('HTTP/1.1 403 Forbidden');
        $this->cause = $i_cause;
        return $this;
    }

    public function _404($i_cause = '')
    {
        $this->_header('HTTP/1.1 404 Not Found');
        $this->cause = $i_cause;
        return $this;
    }

    /**
     * redirection
     * @param string $i_location
     */
    public function redirect($i_location)
    {
        $this->_header("location: $i_location");
        exit;
    }
    
    public function cachePublic()
    {
        $this->_header('Cache-control: public');
        return $this;
    }
    
    public function bye($i_str = null)
    {
        $i_str && print($i_str);
        exit;
    }
}

