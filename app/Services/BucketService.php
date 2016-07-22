<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 12:37 AM
 */

namespace App\Services;


class BucketService
{
    /**
     * @var string
     */
    protected static $bucket = 'http://www.pokemon-map.com/images';

    public function bucket() {

        return self::$bucket;
    }
}