<?php

namespace Af\Request;

class Cookie extends Request {
    
    protected bool $settable = false;
    protected $settings = [
        'expires' => 0,
        'path' => '',
        'domain' => '',
        'secure' => false,
        'httponly' => false
    ];
    
    protected $nexts = [];
    
    /**
     * defaults settings : {      <br />
     *   expires: 0,              <br />
     *   path: '',                <br />
     *   domain: '',              <br />
     *   secure: false,           <br />
     *   httponly: false          <br />
     * }
     * @param mixed[] $settings
     * @return $this
     */
    public function settings($settings) {
        $this->settings += array_intersect_key($this->settings, $settings);
        
        if (is_string($this->settings['expires'])) {
            $this->settings['expires'] = strtotime($this->settings['expires']);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value) {
        list($expires, $path, $domain, $secure, $httponly) = $this->settings;
        $set = setrawcookie($name, rawurlencode($value), $expires, $path, $domain, $secure, $httponly);
        if (!$set) {
            throw new Exception("cookie $name won't be set");
        }
        $this->nexts[$name] = $value;
        return $this;
    }
    
    public function hasNext($name) {
        return ! empty($this->nexts[$name]);
    }
    
    public function getNext($name, $default = null) {
        if (empty($this->nexts[$name]) && !isset($default)) {
            throw new Exception("no cookie $name for next");
        }
        return $this->nexts[$name];
    }
}
