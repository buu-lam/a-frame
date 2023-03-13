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
    
    public function testAppendContent() {
        $path = tempnam(sys_get_temp_dir(), 'a-frame-unit-test-format-file');
        (new Str($path))
            ->appendContent("test ok\n")
            ->appendContent("very ok\n")
        ;
        expect(file_get_contents($path))->toBe("test ok\nvery ok\n");
    }
    
    public function testWriteToFile() {
        $path = tempnam(sys_get_temp_dir(), 'a-frame-unit-test-format-file');
        (new Str('test ok'))->writeToFile($path);
        expect(file_get_contents($path))->toBe('test ok');
        return $this;
    }
    
    public function testAppendToFile() {
         $path = tempnam(sys_get_temp_dir(), 'a-frame-unit-test-format-file');
        (new Str("test ok\n"))->appendToFile($path);
        (new Str("very ok\n"))->appendToFile($path);
        expect(file_get_contents($path))->toBe("test ok\nvery ok\n");
        return $this;
    }
    
    public function testMTime() {
        $this->markTestIncomplete();
    }
    
    public function testChmod() {
        $this->markTestIncomplete();
    }
    
    public function testChown() {
        $this->markTestIncomplete();
    }
}
