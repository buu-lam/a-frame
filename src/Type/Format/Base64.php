<?php

namespace Af\Type\Format;

trait Base64 {
    public function base64Encode() {
        return $this->cloned(
                base64_encode($this->value)
        );
    }
    
    public function base64Decode() {
        return $this->cloned(
                base64_decode($this->value)
        );
    }
}
