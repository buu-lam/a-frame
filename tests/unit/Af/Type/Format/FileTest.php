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
    
    public function testDirname() {
        expect((new Str('/nested/dir/file.txt'))->dirname()->get())->toBe('/nested/dir');
        expect((new Str('/nested/dir/file.txt'))->dirname(2)->get())->toBe('/nested');
    }
    
    public function testBasename() {
        expect((new Str('/nested/dir/file.txt'))->basename()->get())->toBe('file.txt');
        expect((new Str('/nested/dir/file.txt'))->basename('.txt')->get())->toBe('file');
    }
    
    public function testMkdir() {
        $tmp = sys_get_temp_dir();
        $now = date('Y-m-d-H-i-s');
        $uniqid = uniqid($now);
        $dir1 = new Str("$tmp/a-frame-utests-$uniqid");
        $dir1->mkdir();
        expect("$dir1")->directoryToExist();
        
        $dir2 = new Str("$tmp/a-frame-utests-$uniqid-2/nested");
        $dir2->mkdir(0775, true);        
        expect("$dir2")->directoryToExist();
    }
    
    public function testCopyTo() {
        $tmp = sys_get_temp_dir();
        $now = date('Y-m-d-H-i-s');
        $uniqid = uniqid($now);
        $path = "$tmp/a-frame-utests-$uniqid.txt";
        $pathTo = "$tmp/a-frame-utests-$uniqid-to.txt";
        file_put_contents($path, 'ok');
        (new Str($path))->copyTo($pathTo);
        expect(file_get_contents($pathTo))->toBe('ok');
        
        $path1 = "$tmp/a-frame-utests-$uniqid-pattern-1.txt";
        file_put_contents($path1, 'ok');
        $path2 = "$tmp/a-frame-utests-$uniqid-pattern-2.txt";
        file_put_contents($path2, 'ok');
        
        $pathPatternTo = "$tmp/a-frame-$uniqid";
        mkdir($pathPatternTo);
        
        (new Str("$tmp/a-frame-utests-$uniqid-pattern-*.txt"))->copyTo($pathPatternTo);
        expect(file_get_contents("$pathPatternTo/a-frame-utests-$uniqid-pattern-1.txt"))->toBe('ok');
        expect(file_get_contents("$pathPatternTo/a-frame-utests-$uniqid-pattern-2.txt"))->toBe('ok');
        
        $dirTo = "$tmp/a-frame-$uniqid-dir-to";
        mkdir($dirTo);
        (new Str("$tmp/a-frame-utests-$uniqid-pattern-1.txt"))->copyTo($dirTo);
        expect(file_get_contents("$dirTo/a-frame-utests-$uniqid-pattern-1.txt"))->toBe('ok');
    }
    
    public function testGlob() {
        $tmpDir = sys_get_temp_dir() . uniqid('str-glob-');
        mkdir($tmpDir);
        touch("$tmpDir/test-1-1.txt");
        touch("$tmpDir/test-1-2.txt");
        mkdir("$tmpDir/test-dir");
        
        $files = (new Str("$tmpDir/test-1-*.txt"))->glob()->get();
        
        expect($files)->arrayToHaveCount(2);
        expect($files)->arrayToContain("$tmpDir/test-1-1.txt");
        expect($files)->arrayToContain("$tmpDir/test-1-2.txt");
        
        $dirs = (new Str("$tmpDir/*"))->glob(GLOB_ONLYDIR)->get();
        expect($dirs)->arrayToHaveCount(1);
        expect($dirs)->arrayToContain("$tmpDir/test-dir");
    }
    
    public function testFileSize() {
        expect((new Str('tests/_data/filesize.txt'))->fileSize())->toBe(9);
    }
}
