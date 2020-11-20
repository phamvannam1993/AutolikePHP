<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/29/2018
 * Time: 12:48 AM
 */

namespace App\Helpers;

class JavaJobApiHelper
{
    public static function requestApi($url, $method, $data) {
        return BaseCurlHelper::request(
            $url,
            $method,
            [
                "cache-control: no-cache",
                //"content-type: multipart/form-data"
            ],
            $data
        );
    }
}