<?php

namespace Af\Request;

class Session extends Request {
    
    protected $settable = true;

    public function onInit() {
        session_start();
    }
}
