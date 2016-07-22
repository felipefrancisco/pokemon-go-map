<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 1:04 AM
 */

namespace App\Services;

use App\ApiKey;
use App\ApiLog;
use Illuminate\Http\Request;

class SessionService
{
    /**
     * SessionService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->session = $request->session();
    }

    /**
     * @param $key
     */
    public function get($key) {

        $this->session->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {

        $this->session->put($key, $value);
    }
}