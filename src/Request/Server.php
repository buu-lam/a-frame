<?php

namespace Af\Request;

/**
 * @property-read string[] $argv
 * @property-read integer $argc
 * @property-read string $auth_type
 * @property-read string $document_root
 * @property-read string $http_accept
 * @property-read string $http_accept_encoding
 * @property-read string $http_accept_language
 * @property-read string $http_connection
 * @property-read string $http_host
 * @property-read string $http_referer
 * @property-read string $http_user_agent
 * @property-read string $https
 * @property-read string $path_info
 * @property-read string $php_auth_digest
 * @property-read string $php_auth_user
 * @property-read string $php_auth_pw
 * @property-read string $php_self
 * @property-read string $redirect_remote_user
 * @property-read string $remote_addr
 * @property-read string $remote_host
 * @property-read string $remote_port
 * @property-read string $remote_user
 * @property-read string $request_method
 * @property-read string $request_time
 * @property-read string $request_time_float
 * @property-read string $request_uri
 * @property-read string $query_string
 * @property-read string $script_name
 * @property-read string $server_addr
 * @property-read string $server_admin
 * @property-read string $server_name
 * @property-read string $server_port
 * @property-read string $server_protocol
 * @property-read string $server_signature
 * @property-read string $server_software
 * 
 */
class Server extends Request {

    public function get($name) {
        return parent::get(strtoupper($name));
    }

    public function referer() {
        return $this->http_referer;
    }

    public function ip() {
        foreach ([
        'HTTP_X_REAL_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_FROM',
        'REMOTE_ADDR'
        ] as $v) {
            if (!isset($this->value)) {
                continue;
            }
            if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $this->$v)) {
                return $this->$v;
            }
        }
        return '';
    }

}
