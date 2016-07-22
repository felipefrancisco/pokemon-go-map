<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 1:33 AM
 */

namespace App\Services;

use App\Library\Memcached\Client;

class CacheService
{
    /**
     * @var Client
     */
    public $instance;

    /**
     * CacheService constructor.
     */
    public function __construct()
    {
        $this->instance = new Client();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key) {

        return $this->instance->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @param int $ttl
     * @return $this
     */
    public function set($key, $value, $ttl = 60) {

        return $this->instance->set($key, $value, $ttl);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function forget($key) {

        return $this->instance->forget($key);
    }
}