<?php
namespace App\Http\Controllers\Api;
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/18/2018
 * Time: 7:45 PM
 */

use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProxyController extends Controller
{
    public function __construct()
    {
    }

    public function getProxy()
    {
        $result = Redis::scan(1, 'match', '*');
        $count = $result[0];
        $data = $result[1];
        $firstKey = $data[0];
        $proxy = Redis::get($firstKey);
        $proxy = str_replace("'", '"', $proxy);
        $proxyData = json_decode($proxy, TRUE);
        echo json_encode($proxyData);
        Redis::del($firstKey);
        die;
    }

    public function checkIP(Request $request)
    {
        $userIp = $request->ip();
        return ResponseJson::responseSuccess(["ip" => $userIp], 'Fùnction success');
    }

    private function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

}