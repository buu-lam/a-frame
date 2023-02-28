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
}
