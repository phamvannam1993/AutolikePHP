<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/29/2018
 * Time: 12:14 AM
 */

namespace App\Helpers;

class Like4VipAdminApi
{
    public static function requestApi($url, $method, $data) {
        $curl = curl_init();
        $data["secret_token"] = env('ADMIN_API_SECRET');
        $header = ["cache-control: no-cache"];
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        //echo $response;die;
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