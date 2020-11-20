<?php
namespace App\Http\Controllers\Api;
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/18/2018
 * Time: 7:45 PM
 */

use App\Http\Controllers\Controller;
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

}