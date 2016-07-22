<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/17/2016
 * Time: 8:32 PM
 */

namespace App\Library;

class QuickGit {

    private static $version = 'v0';

    public static function version() {

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            return 'local';

        exec('git describe --always',$version_mini_hash);
        exec('git rev-list HEAD | wc -l',$version_number);
        exec('git log -1',$line);

        $version['short'] = self::$version .".".trim($version_number[0]).".".$version_mini_hash[0];
        $version['full'] = self::$version .".".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";

        return $version['short'];
    }

}