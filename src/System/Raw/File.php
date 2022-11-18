<?php

namespace Af\System\Raw;

class File {
    /**
     * 
     * @param string $filename
     * @param bool $use_include_path
     * @param resource $context
     * @param int $offset
     * @param int $maxlen
     * @return string
     */
    public function get_contents($filename, $use_include_path = false, $context = null, $offset = 0, $maxlen = null) {
        return file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
    }
    
    /**
     * 
     * @param string $filename
     * @param string $data
     * @param int $flags
     * @param resource $context
     * @return string
     */
    public function put_contents($filename, $data, $flags = 0, $context = null) : int {
        return file_put_contents($filename, $data, $flags, $context);
    }
    
    /**
     * 
     * @param string $filename
     * @return bool
     */
    public function exists($filename) {
        return file_exists($filename);
    }
}
