<?php

namespace Af\Request;

class ServerTest extends \Codeception\Test\Unit {

    public function testGet() {
        $server = new Server();
        $server->bind($_SERVER);
        
        expect($server->php_self)->toEqual($_SERVER['PHP_SELF']);
    }

    public function testReferer() {
        $referer = 'https://www.test.com';
        $server = new Server(['HTTP_REFERER' => $referer]);
        expect($server->referer())->toEqual($referer);
    }
    
    public function testIp() {
        $HTTP_X_REAL_IP = '5.5.5.1';
        $HTTP_CLIENT_IP = '5.5.5.2'; 
        $HTTP_X_FORWARDED_FOR = '5.5.5.3'; 
        $HTTP_X_FORWARDED = '5.5.5.4'; 
        $HTTP_FORWARDED_FOR = '5.5.5.5'; 
        $HTTP_FORWARDED = '5.5.5.6';
        $HTTP_FROM = '5.5.5.7'; 
        $REMOTE_ADDR = '5.5.5.8';
        
        $server = [];
        expect((new Server($server))->ip())->toEqual('');
        expect((new Server($server += compact('REMOTE_ADDR')))->ip())->toEqual($REMOTE_ADDR);
        expect((new Server($server += compact('HTTP_FROM')))->ip())->toEqual($HTTP_FROM);
        expect((new Server($server += compact('HTTP_FORWARDED')))->ip())->toEqual($HTTP_FORWARDED);
        expect((new Server($server += compact('HTTP_FORWARDED_FOR')))->ip())->toEqual($HTTP_FORWARDED_FOR);
        expect((new Server($server += compact('HTTP_X_FORWARDED')))->ip())->toEqual($HTTP_X_FORWARDED);
        expect((new Server($server += compact('HTTP_X_FORWARDED_FOR')))->ip())->toEqual($HTTP_X_FORWARDED_FOR);
        expect((new Server($server += compact('HTTP_CLIENT_IP')))->ip())->toEqual($HTTP_CLIENT_IP);
        expect((new Server($server += compact('HTTP_X_REAL_IP')))->ip())->toEqual($HTTP_X_REAL_IP);
    }
}
