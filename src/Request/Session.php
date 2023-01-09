<?php

namespace Af\Request;

use Af\System\Raw\Session as RawSession;

class Session extends Request {
    
    protected bool $settable = true;
 
    protected RawSession $raw;

    protected string $sessionId = '';
    
    public function initWithRaw(RawSession $raw) {
        $this->raw = $raw;
        $this->raw->start();
        $this->sessionId = $this->raw->id();
    }

    public function id() {
        return $this->sessionId;
    }
    
    public function ensure() {
        if (!$this->sessionId) {
            throw new Exception('no session id');
        }
    }
}
