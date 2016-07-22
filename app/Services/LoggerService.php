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

class LoggerService
{
    /**
     * @param Request $request
     * @param ApiKey $apiKey
     * @return bool
     */
    public function logRequest(Request $request, ApiKey $apiKey) {

        $log = new ApiLog();

        $log->ip = $request->ip();
        $log->request = json_encode($request->all());
        $log->api_key_id = $apiKey->id;
        $log->url = $request->fullUrl();

        return $log->save();
    }

    /**
     * @param ApiLog $log
     * @param array $response
     * @return bool
     */
    public function logResponse(ApiLog $log, array $response) {

        $log->response = json_encode($response);

        return $log->save();
    }
}