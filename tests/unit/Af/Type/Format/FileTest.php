<?php

namespace Af\Type\Format;

use \Af\Type\Str;

class FileTest extends \Codeception\Test\Unit {


    public function testIsAFile() {
        expect((new Str('unknown-really--random-name.txt'))->isAFile())->toBeFalse();
        expect((new Str(__FILE__))->isAFile())->toBeTrue();
        expect((new Str(__DIR__))->isAFile())->toBeTrue();
    }
    
    public function testGetContent() {
        expect((new Str(__FILE__))->getContent()->get())->stringToContainString('class FileTest');
    }
    
    public function testPutContent() {
        $path = tempnam(sys_get_temp_dir(), 'a-frame-unit-test-format-file');
        (new Str($path))->putContent(file_get_contents(__FILE__));
        expect($path)->fileToBeEqual(__FILE__);
    }
    
    public function appendContent($content) {
        $path = tempnam(sys_get_temp_dir(), 'a-frame-unit-test-format-file');
        (new Str($path))
            ->appendContent("test ok\n")
            ->appendContent("very ok\n")
        ;
        expect(file_get_contents($path))->toBe("test ok\nvery ok\n");
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
}
