<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/29/2018
 * Time: 12:49 AM
 */

namespace App\Helpers;

class BaseCurlHelper
{
    public static function request($url, $method, $header, $data) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => http_build_query($data, '', '&'),
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return [
                'success' => FALSE,
                'response' => '',
                'msg' => $err
            ];
        } else {
            return [
                'success' => TRUE,
                'response' => $response,
                'msg' => $err
            ];
        }
    }
}