<?php

namespace Af\Type\Format;

use \Af\Type\Str;

trait File {

    public function isAFile(): bool {
        return file_exists($this->value);
    }
    
    public function getContent() : Str {
        return $this->cloned(
            file_get_contents($this->value)
        );
    }
    
    public function putContent($content) : string {
        file_put_contents($this->value, $content);
        return $this;
    }
    
    public function appendContent($content) : string {
        file_put_contents($this->value, $content, FILE_APPEND);
        return $this;
    }
    
    public function mTime() {
        return filemtime($this->value);
    }
    
    public function writeToFile($path) {
        file_put_contents($path, $this->value);
        return $this;
    }
    
    public function appendToFile($path) {
        file_put_contents($path, $this->value, FILE_APPEND);
        return $this;
    }
}
