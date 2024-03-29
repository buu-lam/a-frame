<?php

namespace Af\Type\Format;

use \Af\Type\Str;

trait File {

    public function isAFile(): bool {
        return file_exists($this->value);
    }
    
    public function isADirectory(): bool {
        return is_dir($this->value);
    }
    
    public function getContent() : Str {
        return $this->cloned(
            file_get_contents($this->value)
        );
    }
    
    public function putContent($content) {
        file_put_contents($this->value, $content);
        return $this;
    }
    
    public function appendContent($content) {
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
    
    public function chmod(int $permissions) {
        chmod($this->value, $permissions);
        return $this;
    }
    
    public function chown($user) {
        chown($this->value, $user);
        return $this;
    }
    
    public function dirname(int $levels = 1) {
        return $this->cloned(
            dirname($this->value, $levels)
        );
    }
    
    public function basename(string $suffix = '') {
        return $this->cloned(
            basename($this->value, $suffix)
        );
    }
    
    public function mkdir(int $permissions = 0777, bool $recursive = false, /*?resource*/ $context = null) {
        mkdir($this->value, $permissions, $recursive, $context);
        return $this;
    }
    
    
    public function copyTo($to, /*?resource*/ $context = null) {
        copy($this->value, "$to", $context);
        $this;
    }
    
    
}
