<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/14/2016
 * Time: 11:54 PM
 */

namespace App\Library\Memcached;

class Client
{
    public static $instance;

    protected $host;
    protected $port;

    public function __construct() {

        $this->instance();
    }

    public function instance() {

        if(self::$instance !== null)
            return self::$instance;

        $this->host = '127.0.0.1';
        $this->port = 11211;

        if(class_exists('Memcache')) {

            self::$instance = new \Memcache();
            $this->instance()->connect($this->host,  $this->port);
        }
        elseif(class_exists('Memcached')) {

            self::$instance = new \Memcached();
            $this->instance()->addServer($this->host, $this->port);
        }
        else throw new \Exception('Memcached/Memcache not found');
    }

    public function set($key, $data, $ttl) {

        $class = get_class($this->instance());

        if($class == 'Memcached') {

            $this->instance()->set($key, $data, $ttl);
        }
        elseif($class == 'Memcache') {

            $this->instance()->set($key, $data, false, $ttl);
        }

        return $this;
    }

    public function get($key) {

        return $this->instance()->get($key);
    }

    public function forget($key) {

        $this->instance()->set($key, null);

        return $this;
    }
}