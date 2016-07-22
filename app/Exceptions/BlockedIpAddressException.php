<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 1:22 AM
 */

namespace App\Exceptions;


class BlockedIpAddressException extends \Exception
{
    public function __construct($message = null, $code = 0, Exception $previous)
    {
        $message = 'Your IP has been blocked due to map abusing.';

        parent::__construct($message, $code, $previous);
    }
}